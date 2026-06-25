<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyView;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class PublicPropertyController extends Controller
{
    public function home(): View
    {
        return view('welcome', [
            'settings' => [
                'phone' => Setting::getValue('contact', 'phone', '(555) 010-1000'),
                'email' => Setting::getValue('contact', 'email', 'hello@estateflow.test'),
                'address' => Setting::getValue('contact', 'address', '120 Market Street, Austin, TX'),
            ],
            'featuredProperties' => Property::query()
                ->published()
                ->with(['agent', 'primaryImage'])
                ->where('is_featured', true)
                ->latest('published_at')
                ->take(3)
                ->get(),
            'latestProperties' => Property::published()->with(['agent', 'primaryImage'])->latest('published_at')->take(6)->get(),
            'saleProperties' => Property::published()->where('listing_type', 'For Sale')->with('primaryImage')->latest('published_at')->take(3)->get(),
            'rentalProperties' => Property::published()->where('listing_type', 'For Rent')->with('primaryImage')->latest('published_at')->take(3)->get(),
            'reducedProperties' => Property::published()->where('is_price_reduced', true)->with('primaryImage')->latest('updated_at')->take(3)->get(),
            'openHouseProperties' => Property::published()->where('has_open_house', true)->with('primaryImage')->orderBy('open_house_at')->take(3)->get(),
            'agents' => \App\Models\User::agents()->where('is_active', true)->withCount(['properties' => fn ($query) => $query->published()])->take(3)->get(),
            'propertiesByCity' => Cache::remember('home.properties_by_city', 900, fn () => Property::published()->selectRaw('city, count(*) as total')->groupBy('city')->orderByDesc('total')->take(6)->get()),
            'propertiesByType' => Cache::remember('home.properties_by_type', 900, fn () => Property::published()->selectRaw('type, count(*) as total')->groupBy('type')->orderByDesc('total')->get()),
            'propertyCount' => Cache::remember('home.property_count', 900, fn () => Property::published()->count()),
            'cityCount' => Cache::remember('home.city_count', 900, fn () => Property::published()->distinct('city')->count('city')),
        ]);
    }

    public function index(Request $request): View
    {
        $filterKeys = ['search', 'reference_number', 'type', 'listing_type', 'city', 'area', 'min_price', 'max_price', 'bedrooms', 'bathrooms', 'min_area', 'furnishing_status', 'featured', 'open_house', 'price_reduced', 'recently_added', 'amenities'];
        $filters = $request->only($filterKeys);
        $properties = Property::query()
            ->published()
            ->filter($filters)
            ->with(['agent', 'primaryImage'])
            ->sorted($request->input('sort'))
            ->paginate(9)
            ->withQueryString();

        return view('properties.index', [
            'properties' => $properties,
            'types' => Property::TYPES,
            'listingTypes' => Property::LISTING_TYPES,
            'furnishingStatuses' => Property::FURNISHING_STATUSES,
            'amenities' => ['Pool', 'Garage', 'Balcony', 'Gym', 'Security', 'Garden', 'Pet friendly', 'Elevator'],
            'cities' => Cache::remember('public.cities', 900, fn () => Property::published()->select('city')->distinct()->orderBy('city')->pluck('city')),
            'activeFilters' => collect($filters)->filter(fn ($value) => filled($value)),
            'resultCount' => $properties->total(),
            'viewMode' => $request->input('view', 'grid'),
        ]);
    }

    public function show(Request $request, Property $property): View
    {
        abort_unless($property->status === Property::STATUS_PUBLISHED, 404);

        PropertyView::create([
            'user_id' => $request->user()?->id,
            'property_id' => $property->id,
            'session_id' => $request->session()->getId(),
            'ip_address' => $request->ip(),
        ]);

        $recentlyViewedIds = collect($request->session()->get('recently_viewed', []))->reject(fn ($id) => (int) $id === $property->id)->prepend($property->id)->take(6)->values();
        $request->session()->put('recently_viewed', $recentlyViewedIds->all());

        return view('properties.show', [
            'property' => $property->load(['agent', 'images']),
            'relatedProperties' => Property::published()->whereKeyNot($property->id)->where('city', $property->city)->with('primaryImage')->take(3)->get(),
            'similarPriceProperties' => Property::published()->whereKeyNot($property->id)->whereBetween('price', [(float) $property->price * 0.85, (float) $property->price * 1.15])->with('primaryImage')->take(3)->get(),
            'nearbyProperties' => Property::published()->whereKeyNot($property->id)->where('neighbourhood', $property->neighbourhood)->with('primaryImage')->take(3)->get(),
        ]);
    }
}
