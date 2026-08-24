<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        Company::all()->each(function ($company) {
            // 1 proprietário por company
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

        // Cliente demo com credenciais conhecidas para testar a API do app
        $company = Company::first();

        $demo = Customer::factory()->for($company)->create([
            'name' => 'Cliente Demo',
            'email' => 'cliente@demo.com',
            'password' => Hash::make('password'),
        ]);
        $demo->assignRole('client');
    }
}
