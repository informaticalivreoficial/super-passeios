<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\TourDate;
use App\Models\User;

class TourDatePolicy
{
    public function view(User|Customer $user, TourDate $tourDate): bool
    {
        if ($user instanceof Customer) {
            return $user->company_id === $tourDate->tour->company_id;
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

    public function update(User|Customer $user, TourDate $tourDate): bool
    {
        if ($user instanceof Customer) {
            return $user->isProprietary()
                && $user->company_id === $tourDate->tour->company_id;
        }

        return $user->isSuperAdmin() || $user->isAdmin() || $user->isManager();
    }

    public function delete(User|Customer $user, TourDate $tourDate): bool
    {
        if ($user instanceof Customer) {
            return $user->isProprietary()
                && $user->company_id === $tourDate->tour->company_id;
        }

        return $user->isSuperAdmin() || $user->isAdmin();
    }
}