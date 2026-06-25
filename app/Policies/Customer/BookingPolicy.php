<?php

namespace App\Policies\Customer;

use App\Models\Booking;
use App\Models\Customer;

class BookingPolicy
{
    public function viewAny(Customer $customer): bool
    {
        return $customer->isProprietary() || $customer->isClient();
    }

    public function view(Customer $customer, Booking $booking): bool
    {
        if ($customer->isProprietary()) {
            return $customer->company_id === $booking->tour->company_id;
        }

        // client vê apenas as próprias reservas
        return $customer->id === $booking->customer_id;
    }

    public function create(Customer $customer): bool
    {
        return $customer->isProprietary() || $customer->isClient();
    }

    public function update(Customer $customer, Booking $booking): bool
    {
        if ($customer->isProprietary()) {
            return $customer->company_id === $booking->tour->company_id;
        }

        return false;
    }

    public function cancel(Customer $customer, Booking $booking): bool
    {
        if ($customer->isProprietary()) {
            return $customer->company_id === $booking->tour->company_id;
        }

        return $customer->id === $booking->customer_id;
    }

    public function delete(Customer $customer, Booking $booking): bool
    {
        return $customer->isProprietary()
            && $customer->company_id === $booking->tour->company_id;
    }
}