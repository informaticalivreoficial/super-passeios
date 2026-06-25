<?php

namespace App\Policies\Customer;

use App\Models\Company;
use App\Models\Customer;

class CompanyPolicy
{
    public function view(Customer $customer, Company $company): bool
    {
        return $customer->company_id === $company->id;
    }

    public function update(Customer $customer, Company $company): bool
    {
        return $customer->isProprietary()
            && $customer->company_id === $company->id;
    }
}