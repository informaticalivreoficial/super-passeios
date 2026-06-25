<?php

namespace App\Policies\Customer;

use App\Models\Customer;
use App\Models\TourDate;

class TourDatePolicy
{
    public function view(Customer $customer, TourDate $tourDate): bool
    {
        return $customer->company_id === $tourDate->tour->company_id;
    }

    public function create(Customer $customer): bool
    {
        return $customer->isProprietary();
    }

    public function update(Customer $customer, TourDate $tourDate): bool
    {
        return $customer->isProprietary()
            && $customer->company_id === $tourDate->tour->company_id;
    }

    public function delete(Customer $customer, TourDate $tourDate): bool
    {
        return $customer->isProprietary()
            && $customer->company_id === $tourDate->tour->company_id;
    }
}