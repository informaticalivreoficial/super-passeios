<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\User;

class CustomerPolicy
{
    public function viewAny(User|Customer $user): bool
    {
        if ($user instanceof Customer) {
            return $user->isProprietary();
        }

        return $user->isSuperAdmin() || $user->isAdmin();
    }

    public function view(User|Customer $user, Customer $model): bool
    {
        if ($user instanceof Customer) {
            if ($user->isProprietary()) {
                return $user->company_id === $model->company_id;
            }

            return $user->id === $model->id;
        }

        return $user->isSuperAdmin() || $user->isAdmin();
    }

    public function create(User|Customer $user): bool
    {
        if ($user instanceof Customer) {
            return $user->isProprietary();
        }

        return $user->isSuperAdmin() || $user->isAdmin();
    }

    public function update(User|Customer $user, Customer $model): bool
    {
        if ($user instanceof Customer) {
            if ($user->isProprietary()) {
                return $user->company_id === $model->company_id
                    && !$model->isProprietary();
            }

            return $user->id === $model->id;
        }

        return $user->isSuperAdmin() || $user->isAdmin();
    }

    public function delete(User|Customer $user, Customer $model): bool
    {
        if ($user instanceof Customer) {
            if ($user->id === $model->id) return false;

            return $user->isProprietary()
                && $user->company_id === $model->company_id
                && !$model->isProprietary();
        }

        if ($user->id === $model->id) return false;

        return $user->isSuperAdmin() || $user->isAdmin();
    }
}