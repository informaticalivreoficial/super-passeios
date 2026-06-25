<?php

namespace App\Policies\Customer;

use App\Models\Customer;

class CustomerPolicy
{
    public function viewAny(Customer $customer): bool
    {
        return $customer->isProprietary();
    }

    public function view(Customer $customer, Customer $model): bool
    {
        if ($customer->isProprietary()) {
            return $customer->company_id === $model->company_id;
        }

        return $customer->id === $model->id;
    }

    public function create(Customer $customer): bool
    {
        return $customer->isProprietary();
    }

    public function update(Customer $customer, Customer $model): bool
    {
        if ($customer->isProprietary()) {
            return $customer->company_id === $model->company_id
                && !$model->isProprietary(); // não edita outro proprietary
        }

        return $customer->id === $model->id;
    }

    public function delete(Customer $customer, Customer $model): bool
    {
        if ($customer->id === $model->id) {
            return false;
        }

        return $customer->isProprietary()
            && $customer->company_id === $model->company_id
            && !$model->isProprietary();
    }
}