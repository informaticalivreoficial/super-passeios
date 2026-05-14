<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
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

    public function view(User $user, User $model): bool
    {
        // Super admin vê tudo
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Próprio perfil
        if ($user->id === $model->id) {
            return true;
        }

        // Empresa vê usuários vinculados à empresa dela
        if ($user->isCompany()) {

            return
                $model->company
                && $model->company->user_id === $user->id;
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
        return
            $user->isSuperAdmin()
            || $user->isCompany();
    }

    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    public function update(User $user, User $model): bool
    {
        // Super admin pode tudo
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Próprio perfil
        if ($user->id === $model->id) {
            return true;
        }

        // Empresa gerencia usuários dela
        if ($user->isCompany()) {

            return
                $model->company
                && $model->company->user_id === $user->id
                && !$model->isSuperAdmin()
                && !$model->isCompany();
        }

        return false;
    }

    /*
    |--------------------------------------------------------------------------
    | Delete
    |--------------------------------------------------------------------------
    */

    public function delete(User $user, User $model): bool
    {
        // Não pode deletar si mesmo
        if ($user->id === $model->id) {
            return false;
        }

        // Super admin pode tudo
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Empresa remove usuários dela
        if ($user->isCompany()) {

            return
                $model->company
                && $model->company->user_id === $user->id
                && !$model->isSuperAdmin()
                && !$model->isCompany();
        }

        return false;
    }
}