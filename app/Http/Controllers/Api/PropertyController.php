<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PropertyResource;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $properties = Property::query()
            ->published()
            ->filter($request->only(['search', 'type', 'listing_type', 'city', 'min_price', 'max_price', 'bedrooms']))
            ->with(['agent', 'images'])
            ->latest('published_at')
            ->paginate(10)
            ->withQueryString();

        return PropertyResource::collection($properties);
    }

    public function show(Property $property): PropertyResource
    {
        abort_unless($property->status === Property::STATUS_PUBLISHED, 404);

        return new PropertyResource($property->load(['agent', 'images']));
    }
}
