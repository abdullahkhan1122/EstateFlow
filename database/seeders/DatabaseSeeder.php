<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@estateflow.test'],
            [
                'name' => 'Maya Sullivan',
                'role' => User::ROLE_ADMIN,
                'phone' => '(555) 010-1000',
                'bio' => 'Operations lead for EstateFlow.',
                'is_active' => true,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ]
        );

        $agents = collect([
            ['name' => 'Nora Patel', 'email' => 'nora@estateflow.test', 'phone' => '(555) 010-2000', 'areas' => ['Austin', 'Raleigh']],
            ['name' => 'Evan Brooks', 'email' => 'evan@estateflow.test', 'phone' => '(555) 010-3000', 'areas' => ['Denver', 'Phoenix']],
            ['name' => 'Lena Ortiz', 'email' => 'lena@estateflow.test', 'phone' => '(555) 010-4000', 'areas' => ['Portland', 'Austin']],
        ])->map(fn (array $agent) => User::updateOrCreate(
            ['email' => $agent['email']],
            [
                'name' => $agent['name'],
                'role' => User::ROLE_AGENT,
                'phone' => $agent['phone'],
                'bio' => 'Licensed property advisor focused on clear communication and responsive service.',
                'photo_url' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=600&q=80',
                'languages' => ['English', 'Spanish'],
                'specialities' => ['Buyer representation', 'Investment properties'],
                'service_areas' => $agent['areas'],
                'social_links' => ['LinkedIn' => 'https://linkedin.com', 'Instagram' => 'https://instagram.com'],
                'office_name' => 'EstateFlow Advisory',
                'is_active' => true,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ]
        ));

        User::updateOrCreate(
            ['email' => 'buyer@estateflow.test'],
            [
                'name' => 'Jordan Buyer',
                'role' => User::ROLE_BUYER,
                'phone' => '(555) 010-5000',
                'is_active' => true,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ]
        );

        foreach ([
            ['contact', 'phone', '(555) 010-1000'],
            ['contact', 'email', 'hello@estateflow.test'],
            ['contact', 'address', '120 Market Street, Austin, TX'],
            ['social', 'linkedin', 'https://linkedin.com'],
            ['social', 'instagram', 'https://instagram.com'],
            ['seo', 'home_meta_description', 'Browse professional real-estate listings, compare properties, save searches, and request viewings with EstateFlow.'],
        ] as [$group, $key, $value]) {
            Setting::updateOrCreate(['group' => $group, 'key' => $key], ['value' => $value]);
        }

        $properties = [
            ['Cedar Ridge Family Home', 'House', 'For Sale', 685000, 715000, 4, 3, 2860, 'Austin', 'Cedar Ridge', 'TX', true, true, true, ['Family room', 'Covered patio', 'Two-car garage', 'Quiet street'], ['Garage', 'Garden', 'Security']],
            ['Pearl District Loft', 'Condo', 'For Rent', 3200, null, 2, 2, 1180, 'Portland', 'Pearl District', 'OR', true, false, false, ['City views', 'Elevator access', 'Secure parking', 'Walkable dining'], ['Elevator', 'Gym', 'Security']],
            ['Sunnyside Townhome', 'Townhome', 'For Sale', 515000, 535000, 3, 3, 1940, 'Denver', 'Sunnyside', 'CO', false, true, true, ['Rooftop deck', 'Mudroom', 'Mountain light', 'Low-maintenance yard'], ['Garage', 'Balcony', 'Pet friendly']],
            ['Arcadia Garden Studio', 'Studio', 'For Rent', 1850, null, 1, 1, 620, 'Phoenix', 'Arcadia', 'AZ', false, false, false, ['Private courtyard', 'Built-in storage', 'Updated bath', 'Shaded entry'], ['Garden', 'Security']],
            ['Oak Hollow Estate', 'House', 'For Sale', 1245000, 1245000, 5, 4, 4380, 'Raleigh', 'Oak Hollow', 'NC', true, true, false, ['Guest suite', 'Study', 'Chef kitchen', 'Wooded lot'], ['Pool', 'Garage', 'Garden', 'Security']],
            ['Market Street Apartment', 'Apartment', 'For Rent', 2450, null, 2, 2, 990, 'Austin', 'Market District', 'TX', false, false, false, ['Fitness center', 'Balcony', 'Transit nearby', 'Package room'], ['Gym', 'Balcony', 'Elevator']],
            ['Willow Creek Lot', 'Land', 'For Sale', 225000, 240000, 0, 0, 7400, 'Denver', 'Willow Creek', 'CO', false, false, true, ['Utilities nearby', 'Level parcel', 'Creek frontage', 'Survey available'], ['Garden']],
            ['Northline Courtyard Condo', 'Condo', 'For Sale', 438000, 438000, 2, 2, 1325, 'Portland', 'Northline', 'OR', false, true, false, ['Courtyard view', 'Open kitchen', 'Bike storage', 'Primary suite'], ['Balcony', 'Security', 'Pet friendly']],
        ];

        $images = [
            [
                'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1600566753376-12c8ab7fb75b?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1554995207-c18c203602cb?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1600607687644-c7171b42498b?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1600566752355-35792bedcfea?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1560448075-bb485b067938?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1560448205-4d9b3e6bb6db?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'https://images.unsplash.com/photo-1600047509807-ba8f99d2cdde?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1600607688969-a5bfcd646154?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'https://images.unsplash.com/photo-1493809842364-78817add7ffb?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1484154218962-a197022b5858?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'https://images.unsplash.com/photo-1500382017468-9049fed747ef?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'https://images.unsplash.com/photo-1560185007-c5ca9d2c014d?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1560185127-6ed189bf02f4?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1560440021-33f9b867899d?auto=format&fit=crop&w=1200&q=80',
            ],
        ];

        foreach ($properties as $index => [$title, $type, $listingType, $price, $originalPrice, $bedrooms, $bathrooms, $areaSqft, $city, $neighbourhood, $state, $featured, $openHouse, $reduced, $features, $amenities]) {
            $property = Property::updateOrCreate(
                ['slug' => Str::slug($title)],
                [
                    'agent_id' => $agents[$index % $agents->count()]->id,
                    'title' => $title,
                    'reference_number' => 'EF-'.str_pad((string) ($index + 1001), 5, '0', STR_PAD_LEFT),
                    'type' => $type,
                    'status' => Property::STATUS_PUBLISHED,
                    'listing_type' => $listingType,
                    'price' => $price,
                    'original_price' => $originalPrice ?: $price,
                    'bedrooms' => $bedrooms,
                    'bathrooms' => $bathrooms,
                    'area_sqft' => $areaSqft,
                    'address' => (100 + $index).' '.fake()->streetName(),
                    'city' => $city,
                    'area' => $neighbourhood,
                    'neighbourhood' => $neighbourhood,
                    'state' => $state,
                    'zip_code' => fake()->postcode(),
                    'availability_date' => now()->addDays($index + 7),
                    'listing_expiry_date' => now()->addMonths(6),
                    'furnishing_status' => $listingType === 'For Rent' ? 'Furnished' : 'Unfurnished',
                    'condition' => $index % 2 === 0 ? 'Excellent' : 'Good',
                    'community' => $neighbourhood.' Community',
                    'floor_number' => $type === 'Land' || $type === 'House' ? null : $index + 1,
                    'total_floors' => $type === 'Land' || $type === 'House' ? null : 12,
                    'year_built' => 2008 + $index,
                    'energy_rating' => ['A', 'B', 'C'][$index % 3],
                    'latitude' => 30.2672 + ($index / 100),
                    'longitude' => -97.7431 - ($index / 100),
                    'description' => "This {$type} is presented with a clear layout, practical finishes, and a location selected for daily convenience. The listing highlights usable rooms, thoughtful storage, and a showing experience designed to help buyers or renters compare options with confidence.",
                    'features' => $features,
                    'amenities' => $amenities,
                    'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                    'virtual_tour_url' => 'https://example.com/virtual-tour/'.Str::slug($title),
                    'is_featured' => $featured,
                    'has_open_house' => $openHouse,
                    'open_house_at' => $openHouse ? now()->addDays($index + 3)->setTime(13, 0) : null,
                    'is_price_reduced' => $reduced,
                    'availability_status' => 'Available',
                    'approval_status' => 'approved',
                    'published_at' => now()->subDays($index + 1),
                ]
            );

            foreach ($images[$index] as $sortOrder => $image) {
                PropertyImage::updateOrCreate(
                    ['property_id' => $property->id, 'sort_order' => $sortOrder],
                    [
                        'path' => $image,
                        'alt_text' => $property->title.' photo '.($sortOrder + 1),
                        'is_primary' => $sortOrder === 0,
                    ]
                );
            }
        }
    }
}
