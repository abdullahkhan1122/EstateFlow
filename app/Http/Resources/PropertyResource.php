<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'type' => $this->type,
            'listing_type' => $this->listing_type,
            'status' => $this->status,
            'price' => (float) $this->price,
            'bedrooms' => $this->bedrooms,
            'bathrooms' => $this->bathrooms,
            'area_sqft' => $this->area_sqft,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'zip_code' => $this->zip_code,
            'description' => $this->description,
            'features' => $this->features ?? [],
            'is_featured' => $this->is_featured,
            'published_at' => $this->published_at?->toISOString(),
            'agent' => [
                'name' => $this->agent?->name,
                'email' => $this->agent?->email,
                'phone' => $this->agent?->phone,
            ],
            'images' => $this->images->map(fn ($image) => [
                'url' => $image->path,
                'alt_text' => $image->alt_text,
                'is_primary' => $image->is_primary,
            ])->values(),
        ];
    }
}
