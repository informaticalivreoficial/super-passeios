<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Tour;
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
            'title' => fake()->sentence(3),
            'slug' => fake()->slug(),
            'tour_type' => fake()->randomElement(['private', 'shared']),
            'price' => fake()->randomFloat(2, 100, 5000),
            'duration' => fake()->numberBetween(2, 12),
            'boarding_place' => fake()->streetName(),
            'description' => fake()->paragraph(),
            'rules' => fake()->paragraph(),
            'active' => true,
        ];
    }

    public function configure(): static
    {
        return $this->afterMaking(function (Tour $tour) {
            if (!$tour->vessel_id) {
                $tour->vessel_id = Vessel::factory()->create()->id;
            }
            if (!$tour->company_id) {
                $tour->company_id = $tour->vessel_id
                    ? (Vessel::find($tour->vessel_id)?->company_id ?? Company::factory()->create()->id)
                    : Company::factory()->create()->id;
            }
        });
    }
}
