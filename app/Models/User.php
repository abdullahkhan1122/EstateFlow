<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public const ROLE_ADMIN = 'admin';

    public const ROLE_AGENT = 'agent';

    public const ROLE_BUYER = 'buyer';

    protected $fillable = [
        'name',
        'email',
        'role',
        'phone',
        'bio',
        'photo_url',
        'languages',
        'specialities',
        'service_areas',
        'social_links',
        'office_name',
        'is_active',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
        'languages' => 'array',
        'specialities' => 'array',
        'service_areas' => 'array',
        'social_links' => 'array',
        'password' => 'hashed',
    ];

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class, 'agent_id');
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function savedSearches(): HasMany
    {
        return $this->hasMany(SavedSearch::class);
    }

    public function propertyViews(): HasMany
    {
        return $this->hasMany(PropertyView::class);
    }

    public function viewingRequests(): HasMany
    {
        return $this->hasMany(ViewingRequest::class);
    }

    public function notificationPreference(): HasOne
    {
        return $this->hasOne(NotificationPreference::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isAgent(): bool
    {
        return $this->role === self::ROLE_AGENT;
    }

    public function isBuyer(): bool
    {
        return $this->role === self::ROLE_BUYER;
    }

    public function scopeAgents(Builder $query): Builder
    {
        return $query->where('role', self::ROLE_AGENT);
    }
}
