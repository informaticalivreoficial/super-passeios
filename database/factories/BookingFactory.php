<?php

namespace Database\Factories;

use App\Enums\BookingStatusEnum;
use App\Enums\PaymentStatusEnum;
use App\Models\Company;
use App\Models\Tour;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $adults = fake()->numberBetween(1, 4);
        $children = fake()->numberBetween(0, 2);
        $childrenFree = fake()->numberBetween(0, 2);
        $price = fake()->randomFloat(2, 50, 500);
        $halfPrice = $price / 2;

        $subtotal = ($adults * $price) + ($children * $halfPrice);

        return [
            'company_id' => function (array $attributes) {
                return Tour::find($attributes['tour_id'])?->company_id ?? Company::factory();
            },
            'customer_name' => fake()->name(),
            'customer_email' => fake()->safeEmail(),
            'customer_phone' => fake()->numerify('119########'),
            'adults' => $adults,
            'children' => $children,
            'children_free' => $childrenFree,
            'payment_method' => fake()->randomElement(['pix', 'card']),
            'subtotal' => $subtotal,
            'commission_amount' => round($subtotal * 0.10, 2),
            'company_amount' => round($subtotal * 0.90, 2),
            'total' => $subtotal,
            'status' => BookingStatusEnum::PENDING,
            'payment_status' => PaymentStatusEnum::PENDING,
        ];
    }
}