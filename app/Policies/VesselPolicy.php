<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vessel;

class VesselPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isSuperAdmin()
            || $user->isAdmin()
            || $user->isManager();
    }

    public function view(User $user, Vessel $vessel): bool
    {
        return $user->isSuperAdmin()
            || $user->isAdmin()
            || $user->isManager();
    }

    public function create(User $user): bool
    {
        return $user->isSuperAdmin()
            || $user->isAdmin()
            || $user->isManager();
    }

    public function update(User $user, Vessel $vessel): bool
    {
        return $user->isSuperAdmin()
            || $user->isAdmin()
            || $user->isManager();
    }

    public function delete(User $user, Vessel $vessel): bool
    {
        return $user->isSuperAdmin()
            || $user->isAdmin();
    }

    public function restore(User $user, Vessel $vessel): bool
    {
        return $user->isSuperAdmin()
            || $user->isAdmin();
    }

    public function forceDelete(User $user, Vessel $vessel): bool
    {
        return $user->isSuperAdmin();
    }
}