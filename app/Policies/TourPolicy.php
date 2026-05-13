<?php

namespace App\Policies;

use App\Models\Tour;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TourPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return
            $user->isSuperAdmin()
            || $user->isCompany();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Tour $tour): bool
    {
        // super admin
        if ($user->isSuperAdmin()) {
            return true;
        }

        // empresa vê apenas os próprios passeios
        if ($user->isCompany()) {

            return
                $user->company
                && $user->company->id === $tour->company_id;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // super admin
        if ($user->isSuperAdmin()) {
            return true;
        }

        // empresa precisa existir
        if ($user->isCompany()) {

            return $user->company()->exists();
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Tour $tour): bool
    {
        // super admin
        if ($user->isSuperAdmin()) {
            return true;
        }

        // empresa edita apenas os próprios passeios
        if ($user->isCompany()) {

            return
                $user->company
                && $user->company->id === $tour->company_id;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Tour $tour): bool
    {
        // super admin
        if ($user->isSuperAdmin()) {
            return true;
        }

        // empresa remove apenas os próprios passeios
        if ($user->isCompany()) {

            return
                $user->company
                && $user->company->id === $tour->company_id;
        }

        return false;
    }

    public function restore(User $user, Tour $tour): bool
    {
        return $this->delete($user, $tour);
    }
    
}
