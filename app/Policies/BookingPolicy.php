<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BookingPolicy
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
    public function view(User $user, Booking $booking): bool
    {
        // Super admin vê tudo
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Empresa vê apenas a própria empresa
        if ($user->isCompany()) {

            return
                $user->company_id === $booking->tour->company_id;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Booking $booking): bool
    {
        // Super admin pode tudo
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Empresa edita apenas ela mesma
        if ($user->isCompany()) {

            return
                $user->company_id === $booking->tour->company_id;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Booking $booking): bool
    {
        // Super admin pode tudo
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Empresa remove apenas embarcações dela
        if ($user->isCompany()) {

            return
                $user->company_id === $booking->tour->company_id;
        }

        return false;
    }
}
