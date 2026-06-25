<?php

namespace App\Policies\Customer;

use App\Models\Customer;
use App\Models\Vessel;

class VesselPolicy
{
    public function viewAny(Customer $customer): bool
    {
        return $customer->isProprietary();
    }

    public function view(Customer $customer, Vessel $vessel): bool
    {
        return $customer->company_id === $vessel->company_id;
    }

    public function create(Customer $customer): bool
    {
        return $customer->isProprietary();
    }

    public function update(Customer $customer, Vessel $vessel): bool
    {
        return $customer->isProprietary()
            && $customer->company_id === $vessel->company_id;
    }

    public function delete(Customer $customer, Vessel $vessel): bool
    {
        return $customer->isProprietary()
            && $customer->company_id === $vessel->company_id;
    }
}