<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\Customer;
use App\Models\User;

class CompanyPolicy
{
    public function viewAny(User|Customer $user): bool
    {
        if ($user instanceof Customer) {
            return $user->isProprietary();
        }

        return $user->isSuperAdmin() || $user->isAdmin() || $user->isManager();
    }

    public function view(User|Customer $user, Company $company): bool
    {
        if ($user instanceof Customer) {
            return $user->company_id === $company->id;
        }

        return $user->isSuperAdmin() || $user->isAdmin() || $user->isManager();
    }

    public function create(User|Customer $user): bool
    {
        if ($user instanceof Customer) {
            return $user->isProprietary() && !$user->company_id;
        }

        return $user->isSuperAdmin() || $user->isAdmin();
    }

    public function update(User|Customer $user, Company $company): bool
    {
        if ($user instanceof Customer) {
            return $user->isProprietary()
                && $user->company_id === $company->id;
        }

        return $user->isSuperAdmin() || $user->isAdmin() || $user->isManager();
    }

    public function delete(User|Customer $user, Company $company): bool
    {
        if ($user instanceof Customer) {
            return false;
        }

        return $user->isSuperAdmin();
    }
}