<?php

namespace App\Policies\Customer;

use App\Models\Customer;
use App\Models\Tour;

class TourPolicy
{
    public function viewAny(Customer $customer): bool
    {
        return $customer->isProprietary();
    }

    public function view(Customer $customer, Tour $tour): bool
    {
        return $customer->company_id === $tour->company_id;
    }

    public function create(Customer $customer): bool
    {
        return $customer->isProprietary();
    }

    public function update(Customer $customer, Tour $tour): bool
    {
        return $customer->isProprietary()
            && $customer->company_id === $tour->company_id;
    }

    public function delete(Customer $customer, Tour $tour): bool
    {
        return $customer->isProprietary()
            && $customer->company_id === $tour->company_id;
    }
}