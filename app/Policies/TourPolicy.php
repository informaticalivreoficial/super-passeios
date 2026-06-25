<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\Tour;
use App\Models\User;

class TourPolicy
{
    public function viewAny(User|Customer $user): bool
    {
        if ($user instanceof Customer) {
            return $user->isProprietary();
        }

        return $user->isSuperAdmin() || $user->isAdmin() || $user->isManager();
    }

    public function view(User|Customer $user, Tour $tour): bool
    {
        if ($user instanceof Customer) {
            return $user->company_id === $tour->company_id;
        }

        return $user->isSuperAdmin() || $user->isAdmin() || $user->isManager();
    }

    public function create(User|Customer $user): bool
    {
        if ($user instanceof Customer) {
            return $user->isProprietary();
        }

        return $user->isSuperAdmin() || $user->isAdmin() || $user->isManager();
    }

    public function update(User|Customer $user, Tour $tour): bool
    {
        if ($user instanceof Customer) {
            return $user->isProprietary()
                && $user->company_id === $tour->company_id;
        }

        return $user->isSuperAdmin() || $user->isAdmin() || $user->isManager();
    }

    public function delete(User|Customer $user, Tour $tour): bool
    {
        if ($user instanceof Customer) {
            return $user->isProprietary()
                && $user->company_id === $tour->company_id;
        }

        return $user->isSuperAdmin() || $user->isAdmin();
    }

    public function restore(User|Customer $user, Tour $tour): void
    {
        if ($user instanceof Customer) {
            return;
        }

        $user->isSuperAdmin() || $user->isAdmin();
    }
}