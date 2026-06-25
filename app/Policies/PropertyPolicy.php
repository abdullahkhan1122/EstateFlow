<?php

namespace App\Policies;

use App\Models\Property;
use App\Models\User;

class PropertyPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->is_active && ($user->isAdmin() || $user->isAgent());
    }

    public function view(User $user, Property $property): bool
    {
        return $user->isAdmin() || $property->agent_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->is_active && ($user->isAdmin() || $user->isAgent());
    }

    public function update(User $user, Property $property): bool
    {
        return $user->isAdmin() || $property->agent_id === $user->id;
    }

    public function delete(User $user, Property $property): bool
    {
        return $user->isAdmin() || $property->agent_id === $user->id;
    }
}
