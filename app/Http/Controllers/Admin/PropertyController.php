<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PropertyRequest;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\PropertyPriceHistory;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PropertyController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Property::class);

        return view('admin.properties.index', [
            'properties' => Property::query()
                ->visibleTo($request->user())
                ->filter($request->only(['search', 'status', 'type', 'listing_type']))
                ->with(['agent', 'primaryImage'])
                ->latest()
                ->paginate(12)
                ->withQueryString(),
            'types' => Property::TYPES,
            'listingTypes' => Property::LISTING_TYPES,
        ]);
    }

    public function create(Request $request): View
    {
        $this->authorize('create', Property::class);

        return view('admin.properties.create', [
            'property' => new Property([
                'status' => Property::STATUS_PUBLISHED,
                'furnishing_status' => 'Unfurnished',
                'availability_status' => 'Available',
            ]),
            'agents' => $this->agents($request),
            'types' => Property::TYPES,
            'listingTypes' => Property::LISTING_TYPES,
        ]);
    }

    public function store(PropertyRequest $request): RedirectResponse
    {
        $this->authorize('create', Property::class);

        DB::transaction(function () use ($request): void {
            $data = $request->normalized();
            $imagePath = $this->imagePath($request, $data['image_path'] ?? null);
            unset($data['image_path'], $data['image']);
            $data['slug'] = $this->uniqueSlug($data['title']);

            if (! $request->user()->isAdmin()) {
                $data['agent_id'] = $request->user()->id;
            }

            $property = Property::create($data);
            $this->syncPrimaryImage($property, $imagePath);
        });

        $this->clearPublicPropertyCache();

        return redirect()->route('admin.properties.index')->with('status', 'Property created.');
    }

    public function edit(Property $property): View
    {
        $this->authorize('update', $property);

        return view('admin.properties.edit', [
            'property' => $property->load('primaryImage'),
            'agents' => $this->agents(request()),
            'types' => Property::TYPES,
            'listingTypes' => Property::LISTING_TYPES,
        ]);
    }

    public function update(PropertyRequest $request, Property $property): RedirectResponse
    {
        $this->authorize('update', $property);

        DB::transaction(function () use ($request, $property): void {
            $data = $request->normalized();
            $imagePath = $this->imagePath($request, $data['image_path'] ?? null);
            unset($data['image_path'], $data['image']);

            if (! $request->user()->isAdmin()) {
                $data['agent_id'] = $request->user()->id;
            }

            if ($property->title !== $data['title']) {
                $data['slug'] = $this->uniqueSlug($data['title'], $property);
            }

            if ($data['status'] === Property::STATUS_PUBLISHED && $property->published_at) {
                $data['published_at'] = $property->published_at;
            }

            if ((float) $property->price !== (float) $data['price']) {
                PropertyPriceHistory::create([
                    'property_id' => $property->id,
                    'previous_price' => $property->price,
                    'new_price' => $data['price'],
                    'changed_by' => $request->user()->id,
                    'changed_at' => now(),
                ]);

                $data['is_price_reduced'] = (float) $data['price'] < (float) $property->price;
            }

            $property->update($data);
            $this->syncPrimaryImage($property, $imagePath);
        });

        $this->clearPublicPropertyCache();

        return redirect()->route('admin.properties.index')->with('status', 'Property updated.');
    }

    public function destroy(Property $property): RedirectResponse
    {
        $this->authorize('delete', $property);
        $property->delete();
        $this->clearPublicPropertyCache();

        return redirect()->route('admin.properties.index')->with('status', 'Property deleted.');
    }

    private function agents(Request $request)
    {
        return $request->user()->isAdmin()
            ? User::agents()->where('is_active', true)->orderBy('name')->get()
            : collect([$request->user()]);
    }

    private function uniqueSlug(string $title, ?Property $property = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $count = 2;

        while (Property::where('slug', $slug)->when($property, fn ($query) => $query->whereKeyNot($property->id))->exists()) {
            $slug = "{$base}-{$count}";
            $count++;
        }

        return $slug;
    }

    private function syncPrimaryImage(Property $property, ?string $imagePath): void
    {
        if (! $imagePath) {
            return;
        }

        PropertyImage::updateOrCreate(
            ['property_id' => $property->id, 'sort_order' => 0],
            [
                'path' => $imagePath,
                'alt_text' => $property->title,
                'is_primary' => true,
            ]
        );
    }

    private function imagePath(PropertyRequest $request, ?string $fallback): ?string
    {
        if (! $request->hasFile('image')) {
            return $fallback;
        }

        return Storage::url($request->file('image')->store('properties', 'public'));
    }

    private function clearPublicPropertyCache(): void
    {
        Cache::forget('home.properties_by_city');
        Cache::forget('home.properties_by_type');
        Cache::forget('home.property_count');
        Cache::forget('home.city_count');
        Cache::forget('public.cities');
    }
}
