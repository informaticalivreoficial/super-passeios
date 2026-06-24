<?php

namespace App\Policies;

use App\Models\Tour;
use App\Models\User;

class TourPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isSuperAdmin()
            || $user->isAdmin()
            || $user->isManager();
    }

    public function view(User $user, Tour $tour): bool
    {
        if ($user->isSuperAdmin() || $user->isAdmin()) {
            return true;
        }

        if ($user->isManager()) {
            return true;
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $user->isSuperAdmin()
            || $user->isAdmin()
            || $user->isManager();
    }

    public function update(User $user, Tour $tour): bool
    {
        if ($user->isSuperAdmin() || $user->isAdmin()) {
            return true;
        }

        if ($user->isManager()) {
            return true;
        }

        return false;
    }

    public function delete(User $user, Tour $tour): bool
    {
        return $user->isSuperAdmin()
            || $user->isAdmin();
    }

    public function restore(User $user, Tour $tour): bool
    {
        return $user->isSuperAdmin()
            || $user->isAdmin();
    }
}