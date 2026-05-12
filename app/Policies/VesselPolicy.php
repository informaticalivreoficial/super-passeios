<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vessel;

class VesselPolicy
{
    /**
     * Listagem de embarcações.
     */
    public function viewAny(User $user): bool
    {
        return
            $user->isSuperAdmin()
            || $user->isCompany();
    }

    /**
     * Visualizar embarcação específica.
     */
    public function view(User $user, Vessel $vessel): bool
    {
        return
            $user->isSuperAdmin()
            || (
                $user->isCompany()
                && $user->company?->id === $vessel->company_id
            );
    }

    /**
     * Criar embarcação.
     */
    public function create(User $user): bool
    {
        return
            $user->isSuperAdmin()
            || (
                $user->isCompany()
                && $user->company?->id
            );
    }

    /**
     * Editar embarcação.
     */
    public function update(User $user, Vessel $vessel): bool
    {
        return
            $user->isSuperAdmin()
            || (
                $user->isCompany()
                && $user->company?->id === $vessel->company_id
            );
    }

    /**
     * Excluir embarcação.
     */
    public function delete(User $user, Vessel $vessel): bool
    {
        return
            $user->isSuperAdmin()
            || (
                $user->isCompany()
                && $user->company?->id === $vessel->company_id
            );
    }

    /**
     * Restaurar embarcação.
     */
    public function restore(User $user, Vessel $vessel): bool
    {
        return
            $user->isSuperAdmin()
            || (
                $user->isCompany()
                && $user->company?->id === $vessel->company_id
            );
    }

    /**
     * Forçar exclusão.
     */
    public function forceDelete(User $user, Vessel $vessel): bool
    {
        return $user->isSuperAdmin();
    }
}