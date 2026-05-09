<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Vessel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tour>
 */
class TourFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_id' => Company::factory(),
            'vessel_id' => Vessel::factory(),
            'uuid' => Str::uuid(),
            'title' => fake()->sentence(3),
            'slug' => fake()->slug(),
            'tour_type' => fake()->randomElement([
                'private',
                'shared',
            ]),
            'price' => fake()->randomFloat(2, 100, 5000),
            'duration' => fake()->numberBetween(2, 12),
            'boarding_place' => fake()->streetName(),
            'description' => fake()->paragraph(),
            'rules' => fake()->paragraph(),
            'active' => true,
        ];
    }
}
