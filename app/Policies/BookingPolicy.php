<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\User;

class BookingPolicy
{
    public function viewAny(User|Customer $user): bool
    {
        if ($user instanceof Customer) {
            return $user->isProprietary() || $user->isClient();
        }

        return $user->isSuperAdmin() || $user->isAdmin() || $user->isManager();
    }

    public function view(User|Customer $user, Booking $booking): bool
    {
        if ($user instanceof Customer) {
            if ($user->isProprietary()) {
                return $user->company_id === $booking->tour->company_id;
            }

            return $user->id === $booking->customer_id;
        }

        return $user->isSuperAdmin() || $user->isAdmin() || $user->isManager();
    }

    public function create(User|Customer $user): bool
    {
        if ($user instanceof Customer) {
            return $user->isProprietary() || $user->isClient();
        }

        return $user->isSuperAdmin() || $user->isAdmin() || $user->isManager();
    }

    public function update(User|Customer $user, Booking $booking): bool
    {
        if ($user instanceof Customer) {
            if ($user->isProprietary()) {
                return $user->company_id === $booking->tour->company_id;
            }

            return false;
        }

        return $user->isSuperAdmin() || $user->isAdmin() || $user->isManager();
    }

    public function cancel(User|Customer $user, Booking $booking): bool
    {
        if ($user instanceof Customer) {
            if ($user->isProprietary()) {
                return $user->company_id === $booking->tour->company_id;
            }

            return $user->id === $booking->customer_id;
        }

        return $user->isSuperAdmin() || $user->isAdmin();
    }

    public function delete(User|Customer $user, Booking $booking): bool
    {
        if ($user instanceof Customer) {
            return $user->isProprietary()
                && $user->company_id === $booking->tour->company_id;
        }

        return $user->isSuperAdmin() || $user->isAdmin();
    }
}