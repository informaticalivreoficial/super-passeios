<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;

class CompanyPolicy
{
    /*
    |--------------------------------------------------------------------------
    | View Any
    |--------------------------------------------------------------------------
    */

    public function viewAny(User $user): bool
    {
        return
            $user->isSuperAdmin()
            || $user->isCompany();
    }

    /*
    |--------------------------------------------------------------------------
    | View
    |--------------------------------------------------------------------------
    */

    public function view(User $user, Company $company): bool
    {
        // Super admin vê tudo
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Empresa vê apenas a própria empresa
        if ($user->isCompany()) {

            return
                $user->company_id === $company->id;
        }

        return false;
    }

    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    public function create(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    public function update(User $user, Company $company): bool
    {
        // Super admin pode tudo
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Empresa edita apenas ela mesma
        if ($user->isCompany()) {

            return
                $user->company_id === $company->id;
        }

        return false;
    }

    /*
    |--------------------------------------------------------------------------
    | Delete
    |--------------------------------------------------------------------------
    */

    public function delete(User $user, Company $company): bool
    {
        return $user->isSuperAdmin();
    }
}