<?php

namespace App\Http\Requests;

use App\Models\Property;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PropertyRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'furnishing_status' => $this->input('furnishing_status', 'Unfurnished'),
            'availability_status' => $this->input('availability_status', 'Available'),
        ]);
    }

    public function authorize(): bool
    {
        return (bool) $this->user()?->is_active && ($this->user()->isAdmin() || $this->user()->isAgent());
    }

    public function rules(): array
    {
        return [
            'agent_id' => ['required', 'exists:users,id'],
            'title' => ['required', 'string', 'max:160'],
            'type' => ['required', Rule::in(Property::TYPES)],
            'status' => ['required', Rule::in([Property::STATUS_DRAFT, Property::STATUS_PUBLISHED, Property::STATUS_ARCHIVED])],
            'listing_type' => ['required', Rule::in(Property::LISTING_TYPES)],
            'price' => ['required', 'numeric', 'min:1', 'max:9999999999'],
            'original_price' => ['nullable', 'numeric', 'min:1', 'max:9999999999'],
            'bedrooms' => ['required', 'integer', 'min:0', 'max:20'],
            'bathrooms' => ['required', 'integer', 'min:0', 'max:20'],
            'area_sqft' => ['required', 'integer', 'min:100', 'max:100000'],
            'address' => ['required', 'string', 'max:190'],
            'city' => ['required', 'string', 'max:90'],
            'area' => ['nullable', 'string', 'max:90'],
            'neighbourhood' => ['nullable', 'string', 'max:90'],
            'state' => ['required', 'string', 'max:90'],
            'zip_code' => ['nullable', 'string', 'max:20'],
            'availability_date' => ['nullable', 'date'],
            'listing_expiry_date' => ['nullable', 'date', 'after_or_equal:availability_date'],
            'furnishing_status' => ['required', Rule::in(Property::FURNISHING_STATUSES)],
            'condition' => ['nullable', 'string', 'max:90'],
            'community' => ['nullable', 'string', 'max:120'],
            'floor_number' => ['nullable', 'integer', 'min:0', 'max:300'],
            'total_floors' => ['nullable', 'integer', 'min:0', 'max:300'],
            'year_built' => ['nullable', 'integer', 'min:1800', 'max:'.now()->addYear()->year],
            'energy_rating' => ['nullable', 'string', 'max:20'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'description' => ['required', 'string', 'min:80'],
            'features' => ['nullable', 'string', 'max:1000'],
            'amenities' => ['nullable', 'string', 'max:1000'],
            'video_url' => ['nullable', 'url', 'max:500'],
            'virtual_tour_url' => ['nullable', 'url', 'max:500'],
            'image_path' => ['nullable', 'url', 'max:500'],
            'image' => ['nullable', 'image', 'max:4096'],
            'is_featured' => ['nullable', 'boolean'],
            'has_open_house' => ['nullable', 'boolean'],
            'open_house_at' => ['nullable', 'date'],
            'availability_status' => ['required', 'string', 'max:90'],
        ];
    }

    public function normalized(): array
    {
        $data = $this->validated();
        $data['features'] = collect(explode(',', (string) ($data['features'] ?? '')))
            ->map(fn (string $feature) => trim($feature))
            ->filter()
            ->values()
            ->all();
        $data['amenities'] = collect(explode(',', (string) ($data['amenities'] ?? '')))
            ->map(fn (string $amenity) => trim($amenity))
            ->filter()
            ->values()
            ->all();
        $data['is_featured'] = (bool) ($data['is_featured'] ?? false);
        $data['has_open_house'] = (bool) ($data['has_open_house'] ?? false);
        $data['original_price'] = filled($data['original_price'] ?? null) ? $data['original_price'] : $data['price'];
        $data['area'] = filled($data['area'] ?? null) ? $data['area'] : ($data['neighbourhood'] ?? null);
        $data['neighbourhood'] = filled($data['neighbourhood'] ?? null) ? $data['neighbourhood'] : ($data['area'] ?? null);
        $data['is_price_reduced'] = (float) $data['original_price'] > (float) $data['price'];
        $data['approval_status'] = $data['status'] === Property::STATUS_PUBLISHED ? 'published' : $data['status'];
        $data['published_at'] = $data['status'] === Property::STATUS_PUBLISHED ? now() : null;

        if (! $data['has_open_house']) {
            $data['open_house_at'] = null;
        }

        return $data;
    }
}
