<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\User;
use App\Models\Vessel;

class VesselPolicy
{
    public function viewAny(User|Customer $user): bool
    {
        if ($user instanceof Customer) {
            return $user->isProprietary();
        }

        return $user->isSuperAdmin() || $user->isAdmin() || $user->isManager();
    }

    public function view(User|Customer $user, Vessel $vessel): bool
    {
        if ($user instanceof Customer) {
            return $user->company_id === $vessel->company_id;
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

    public function update(User|Customer $user, Vessel $vessel): bool
    {
        if ($user instanceof Customer) {
            return $user->isProprietary()
                && $user->company_id === $vessel->company_id;
        }

        return $user->isSuperAdmin() || $user->isAdmin() || $user->isManager();
    }

    public function delete(User|Customer $user, Vessel $vessel): bool
    {
        if ($user instanceof Customer) {
            return $user->isProprietary()
                && $user->company_id === $vessel->company_id;
        }

        return $user->isSuperAdmin() || $user->isAdmin();
    }

    public function restore(User|Customer $user, Vessel $vessel): bool
    {
        if ($user instanceof Customer) {
            return false;
        }

        return $user->isSuperAdmin() || $user->isAdmin();
    }

    public function forceDelete(User|Customer $user, Vessel $vessel): bool
    {
        if ($user instanceof Customer) {
            return false;
        }

        return $user->isSuperAdmin();
    }
}