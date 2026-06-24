<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        Company::all()->each(function ($company) {
            // 1 proprietary por company
            Customer::factory()
                ->for($company)
                ->afterCreating(fn ($customer) => $customer->assignRole('proprietary'))
                ->create();

            // 10 clientes por company
            Customer::factory(10)
                ->for($company)
                ->afterCreating(fn ($customer) => $customer->assignRole('client'))
                ->create();
        });
    }
}
