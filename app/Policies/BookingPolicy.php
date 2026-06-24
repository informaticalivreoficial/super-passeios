<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;

class BookingPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isSuperAdmin()
            || $user->isAdmin()
            || $user->isManager();
    }

    public function view(User $user, Booking $booking): bool
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

    public function update(User $user, Booking $booking): bool
    {
        if ($user->isSuperAdmin() || $user->isAdmin()) {
            return true;
        }

        if ($user->isManager()) {
            return true;
        }

        return false;
    }

    public function delete(User $user, Booking $booking): bool
    {
        return $user->isSuperAdmin()
            || $user->isAdmin();
    }
}