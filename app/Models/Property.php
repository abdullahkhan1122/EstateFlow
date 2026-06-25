<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Property extends Model
{
    use HasFactory;

    public const STATUS_DRAFT = 'draft';

    public const STATUS_PUBLISHED = 'published';

    public const STATUS_ARCHIVED = 'archived';

    public const APPROVAL_STATUSES = ['draft', 'submitted', 'under_review', 'approved', 'rejected', 'published', 'expired', 'archived'];

    public const TYPES = ['House', 'Apartment', 'Condo', 'Townhome', 'Studio', 'Land'];

    public const LISTING_TYPES = ['For Sale', 'For Rent'];

    public const FURNISHING_STATUSES = ['Furnished', 'Semi-furnished', 'Unfurnished'];

    protected $fillable = [
        'agent_id',
        'title',
        'slug',
        'reference_number',
        'type',
        'status',
        'listing_type',
        'price',
        'original_price',
        'bedrooms',
        'bathrooms',
        'area_sqft',
        'address',
        'city',
        'area',
        'neighbourhood',
        'state',
        'zip_code',
        'availability_date',
        'listing_expiry_date',
        'furnishing_status',
        'condition',
        'community',
        'floor_number',
        'total_floors',
        'year_built',
        'energy_rating',
        'latitude',
        'longitude',
        'description',
        'features',
        'amenities',
        'video_url',
        'virtual_tour_url',
        'floor_plan_path',
        'is_featured',
        'has_open_house',
        'open_house_at',
        'is_price_reduced',
        'availability_status',
        'approval_status',
        'internal_notes',
        'rejection_reason',
        'published_at',
    ];

    protected $casts = [
        'features' => 'array',
        'amenities' => 'array',
        'is_featured' => 'boolean',
        'has_open_house' => 'boolean',
        'is_price_reduced' => 'boolean',
        'availability_date' => 'date',
        'listing_expiry_date' => 'date',
        'open_house_at' => 'datetime',
        'published_at' => 'datetime',
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];

    protected static function booted(): void
    {
        static::saving(function (Property $property): void {
            if (! $property->slug) {
                $property->slug = Str::slug($property->title);
            }

            if (! $property->reference_number) {
                $property->reference_number = 'EF-'.str_pad((string) random_int(10000, 99999), 5, '0', STR_PAD_LEFT);
            }

            if ($property->status === self::STATUS_PUBLISHED && ! $property->published_at) {
                $property->published_at = now();
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(PropertyImage::class)->orderBy('sort_order');
    }

    public function inquiries(): HasMany
    {
        return $this->hasMany(PropertyInquiry::class);
    }

    public function views(): HasMany
    {
        return $this->hasMany(PropertyView::class);
    }

    public function viewingRequests(): HasMany
    {
        return $this->hasMany(ViewingRequest::class);
    }

    public function priceHistories(): HasMany
    {
        return $this->hasMany(PropertyPriceHistory::class);
    }

    public function primaryImage()
    {
        return $this->hasOne(PropertyImage::class)->where('is_primary', true)->oldest('sort_order');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_PUBLISHED);
    }

    public function scopeVisibleTo(Builder $query, User $user): Builder
    {
        return $user->isAdmin() ? $query : $query->where('agent_id', $user->id);
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['search'] ?? null, fn (Builder $query, string $search) => $query->where(function (Builder $query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%")
                    ->orWhere('reference_number', 'like', "%{$search}%")
                    ->orWhere('neighbourhood', 'like', "%{$search}%");
            }))
            ->when($filters['reference_number'] ?? null, fn (Builder $query, string $reference) => $query->where('reference_number', 'like', "%{$reference}%"))
            ->when($filters['type'] ?? null, fn (Builder $query, string $type) => $query->where('type', $type))
            ->when($filters['listing_type'] ?? null, fn (Builder $query, string $listingType) => $query->where('listing_type', $listingType))
            ->when($filters['status'] ?? null, fn (Builder $query, string $status) => $query->where('status', $status))
            ->when($filters['city'] ?? null, fn (Builder $query, string $city) => $query->where('city', $city))
            ->when($filters['area'] ?? null, fn (Builder $query, string $area) => $query->where(fn (Builder $query) => $query->where('area', 'like', "%{$area}%")->orWhere('neighbourhood', 'like', "%{$area}%")))
            ->when($filters['min_price'] ?? null, fn (Builder $query, int $price) => $query->where('price', '>=', $price))
            ->when($filters['max_price'] ?? null, fn (Builder $query, int $price) => $query->where('price', '<=', $price))
            ->when($filters['bedrooms'] ?? null, fn (Builder $query, int $bedrooms) => $query->where('bedrooms', '>=', $bedrooms))
            ->when($filters['bathrooms'] ?? null, fn (Builder $query, int $bathrooms) => $query->where('bathrooms', '>=', $bathrooms))
            ->when($filters['min_area'] ?? null, fn (Builder $query, int $area) => $query->where('area_sqft', '>=', $area))
            ->when($filters['furnishing_status'] ?? null, fn (Builder $query, string $status) => $query->where('furnishing_status', $status))
            ->when($filters['featured'] ?? null, fn (Builder $query) => $query->where('is_featured', true))
            ->when($filters['open_house'] ?? null, fn (Builder $query) => $query->where('has_open_house', true))
            ->when($filters['price_reduced'] ?? null, fn (Builder $query) => $query->where('is_price_reduced', true))
            ->when($filters['recently_added'] ?? null, fn (Builder $query) => $query->where('published_at', '>=', now()->subDays(14)))
            ->when($filters['amenities'] ?? null, fn (Builder $query, array|string $amenities) => collect((array) $amenities)->filter()->each(fn (string $amenity) => $query->whereJsonContains('amenities', $amenity)));
    }

    public function scopeSorted(Builder $query, ?string $sort): Builder
    {
        return match ($sort) {
            'price_asc' => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'area_desc' => $query->orderByDesc('area_sqft'),
            'oldest' => $query->orderBy('published_at'),
            default => $query->latest('published_at'),
        };
    }

    public function pricePerSqft(): float
    {
        return $this->area_sqft > 0 ? round((float) $this->price / $this->area_sqft, 2) : 0;
    }
}
