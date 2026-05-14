<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Vessel;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::factory(5)->has(Vessel::factory(3)->hasTours(5))->create();
    }
}
