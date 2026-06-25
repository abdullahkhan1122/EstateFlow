<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PropertyFactory extends Factory
{
    protected $model = Property::class;

    public function definition(): array
    {
        $title = fake()->randomElement(['Bright', 'Modern', 'Quiet', 'Updated', 'Spacious']).' '.fake()->randomElement(Property::TYPES).' in '.fake()->city();

        return [
            'agent_id' => User::factory(),
            'title' => $title,
            'slug' => Str::slug($title).'-'.Str::lower(Str::random(6)),
            'reference_number' => 'EF-'.fake()->unique()->numberBetween(10000, 99999),
            'type' => fake()->randomElement(Property::TYPES),
            'status' => Property::STATUS_PUBLISHED,
            'listing_type' => fake()->randomElement(Property::LISTING_TYPES),
            'price' => fake()->numberBetween(180000, 1400000),
            'original_price' => fake()->numberBetween(180000, 1450000),
            'bedrooms' => fake()->numberBetween(1, 5),
            'bathrooms' => fake()->numberBetween(1, 4),
            'area_sqft' => fake()->numberBetween(700, 5200),
            'address' => fake()->streetAddress(),
            'city' => fake()->randomElement(['Austin', 'Denver', 'Portland', 'Raleigh', 'Phoenix']),
            'area' => fake()->randomElement(['Downtown', 'Northside', 'West End', 'Riverside']),
            'neighbourhood' => fake()->randomElement(['Market District', 'Oak Hollow', 'Cedar Ridge', 'Northline']),
            'state' => fake()->randomElement(['TX', 'CO', 'OR', 'NC', 'AZ']),
            'zip_code' => fake()->postcode(),
            'availability_date' => now()->addDays(fake()->numberBetween(1, 45)),
            'listing_expiry_date' => now()->addMonths(6),
            'furnishing_status' => fake()->randomElement(Property::FURNISHING_STATUSES),
            'condition' => fake()->randomElement(['New', 'Excellent', 'Good']),
            'community' => fake()->company(),
            'year_built' => fake()->numberBetween(1990, 2025),
            'latitude' => fake()->latitude(30, 46),
            'longitude' => fake()->longitude(-122, -75),
            'description' => fake()->paragraphs(3, true),
            'features' => fake()->randomElements(['Garage', 'Patio', 'Open kitchen', 'Walk-in closets', 'Energy efficient', 'Near transit'], 4),
            'amenities' => fake()->randomElements(['Pool', 'Garage', 'Balcony', 'Gym', 'Security', 'Garden', 'Pet friendly', 'Elevator'], 4),
            'is_featured' => fake()->boolean(25),
            'has_open_house' => fake()->boolean(25),
            'open_house_at' => now()->addDays(fake()->numberBetween(2, 30)),
            'is_price_reduced' => fake()->boolean(20),
            'availability_status' => 'Available',
            'approval_status' => 'approved',
            'published_at' => now()->subDays(fake()->numberBetween(1, 60)),
        ];
    }
}
