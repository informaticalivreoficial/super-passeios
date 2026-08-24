<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Tour;
use App\Models\TourDate;
use App\Models\Vessel;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            ['city' => 'Florianópolis', 'state' => 'SC'],
            ['city' => 'Balneário Camboriú', 'state' => 'SC'],
            ['city' => 'São Paulo', 'state' => 'SP'],
            ['city' => 'Rio de Janeiro', 'state' => 'RJ'],
            ['city' => 'Salvador', 'state' => 'BA'],
            ['city' => 'Recife', 'state' => 'PE'],
            ['city' => 'Fortaleza', 'state' => 'CE'],
            ['city' => 'Porto Alegre', 'state' => 'RS'],
            ['city' => 'Curitiba', 'state' => 'PR'],
            ['city' => 'Natal', 'state' => 'RN'],
            ['city' => 'Maceió', 'state' => 'AL'],
            ['city' => 'Vitória', 'state' => 'ES'],
            ['city' => 'Angra dos Reis', 'state' => 'RJ'],
            ['city' => 'Paraty', 'state' => 'RJ'],
            ['city' => 'Ubatuba', 'state' => 'SP'],
            ['city' => 'Ilhabela', 'state' => 'SP'],
            ['city' => 'Santos', 'state' => 'SP'],
            ['city' => 'Guarujá', 'state' => 'SP'],
            ['city' => 'Arraial do Cabo', 'state' => 'RJ'],
            ['city' => 'Búzios', 'state' => 'RJ'],
        ];

        foreach ($locations as $location) {
            $company = Company::factory()->create([
                'status' => true,
                'city' => $location['city'],
                'state' => $location['state'],
            ]);

            Vessel::factory(fake()->numberBetween(1, 3))
                ->for($company)
                ->create()
                ->each(function (Vessel $vessel) use ($company) {
                    Tour::factory(fake()->numberBetween(2, 5))
                        ->for($company)
                        ->for($vessel, 'vessel')
                        ->create()
                        ->each(function (Tour $tour) {
                            TourDate::factory(fake()->numberBetween(3, 8))
                                ->for($tour)
                                ->create();
                        });
                });
        }
    }
}
