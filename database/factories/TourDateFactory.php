<?php

namespace Database\Factories;

use App\Enums\TourDateStatusEnum;
use App\Models\Tour;
use App\Models\TourDate;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TourDate>
 */
class TourDateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $price = fake()->randomFloat(2, 50, 500);

        return [
            'date' => fake()->dateTimeBetween('+1 day', '+60 days')->format('Y-m-d'),
            'price' => $price,
            'half_price' => round($price / 2, 2),
            'start_time' => fake()->randomElement(['08:00', '09:00', '10:00', '13:00', '14:00', '15:00']),
            'end_time' => fake()->randomElement(['12:00', '13:00', '17:00', '18:00', '19:00']),
            'available_slots' => fake()->numberBetween(5, 40),
            'active' => true,
            'status' => TourDateStatusEnum::OPEN,
        ];
    }

    public function configure(): static
    {
        return $this->afterMaking(function (TourDate $tourDate) {
            if (!$tourDate->tour_id) {
                $tourDate->tour_id = Tour::factory()->create()->id;
            }
        });
    }
}
