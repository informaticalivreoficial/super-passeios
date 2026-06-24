<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;

class CompanyPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isSuperAdmin()
            || $user->isAdmin()
            || $user->isManager();
    }

    public function view(User $user, Company $company): bool
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
            || $user->isAdmin();
    }

    public function update(User $user, Company $company): bool
    {
        if ($user->isSuperAdmin() || $user->isAdmin()) {
            return true;
        }

        if ($user->isManager()) {
            return true;
        }

        return false;
    }

    public function delete(User $user, Company $company): bool
    {
        return $user->isSuperAdmin();
    }
}