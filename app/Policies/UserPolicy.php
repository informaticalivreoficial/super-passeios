<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isSuperAdmin()
            || $user->isAdmin();
    }

    public function view(User $user, User $model): bool
    {
        if ($user->isSuperAdmin() || $user->isAdmin()) {
            return true;
        }

        return $user->id === $model->id;
    }

    public function create(User $user): bool
    {
        return $user->isSuperAdmin()
            || $user->isAdmin();
    }

    public function update(User $user, User $model): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($user->isAdmin()) {
            return !$model->isSuperAdmin();
        }

        if ($user->isManager()) {
            return $model->isManager() && $user->id === $model->id
                || !$model->isSuperAdmin() && !$model->isAdmin();
        }

        return $user->id === $model->id;
    }

    public function delete(User $user, User $model): bool
    {
        if ($user->id === $model->id) {
            return false;
        }

        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($user->isAdmin()) {
            return !$model->isSuperAdmin();
        }

        return false;
    }
}