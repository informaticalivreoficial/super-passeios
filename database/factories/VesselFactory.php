<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Vessel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vessel>
 */
class VesselFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'slug' => fake()->slug(),
            'type' => fake()->randomElement([
                'lancha',
                'escuna',
                'veleiro',
                'catamara',
            ]),
            'size' => fake()->numberBetween(2, 60),
            'capacity' => fake()->numberBetween(2, 60),
            'description' => fake()->paragraph(),
            'bathroom' => fake()->numberBetween(2, 60),
            'barbecue' => fake()->boolean(),
            'suite' => fake()->boolean(),
            'sound_system' => fake()->boolean(),
            'kitchen' => fake()->boolean(),
            'active' => true,
        ];
    }

    public function configure(): static
    {
        return $this->afterMaking(function (Vessel $vessel) {
            if (!$vessel->company_id) {
                $vessel->company_id = Company::factory()->create()->id;
            }
        });
    }
}
