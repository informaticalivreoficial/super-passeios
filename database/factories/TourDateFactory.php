<?php

namespace Database\Factories;

use App\Enums\TourDateStatusEnum;
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
        return [
            'date' => fake()->dateTimeBetween('+1 day', '+30 days')->format('Y-m-d'),
            'price' => fake()->randomFloat(2, 50, 500),
            'half_price' => null,
            'start_time' => '09:00',
            'end_time' => '12:00',
            'available_slots' => fake()->numberBetween(1, 20),
            'active' => true,
            'status' => TourDateStatusEnum::OPEN,
        ];
    }
}