<?php

namespace App\Providers;

use App\Models\Property;
use App\Models\User;
use App\Policies\PropertyPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Property::class => PropertyPolicy::class,
        User::class => UserPolicy::class,
    ];

    public function boot(): void
    {
        Gate::define('access-admin', fn (User $user) => $user->is_active && ($user->isAdmin() || $user->isAgent()));
        Gate::define('access-buyer', fn (User $user) => $user->is_active && $user->isBuyer());
    }
}
