<?php

namespace Database\Factories;

use App\Enums\BookingStatusEnum;
use App\Enums\PaymentStatusEnum;
use App\Models\Booking;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Tour;
use App\Models\TourDate;
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
        $halfPrice = round($price / 2, 2);

        $subtotal = ($adults * $price) + ($children * $halfPrice);

        $paymentStatus = fake()->randomElement(PaymentStatusEnum::cases());
        $status = match ($paymentStatus) {
            PaymentStatusEnum::PAID => BookingStatusEnum::CONFIRMED,
            PaymentStatusEnum::PENDING => BookingStatusEnum::PENDING,
            default => BookingStatusEnum::CANCELLED,
        };

        return [
            'uuid' => fake()->uuid(),
            'customer_name' => fake()->name(),
            'customer_email' => fake()->safeEmail(),
            'customer_phone' => fake()->numerify('119########'),
            'adults' => $adults,
            'children' => $children,
            'children_free' => $childrenFree,
            'payment_method' => fake()->randomElement(['pix', 'credit_card']),
            'gateway' => 'pagbank',
            'payment_id' => null,
            'subtotal' => $subtotal,
            'commission_amount' => round($subtotal * 0.10, 2),
            'company_amount' => round($subtotal * 0.90, 2),
            'total' => $subtotal,
            'status' => $status,
            'payment_status' => $paymentStatus,
        ];
    }

    public function configure(): static
    {
        return $this->afterMaking(function (Booking $booking) {
            if (!$booking->customer_id) {
                $booking->customer_id = Customer::factory()->create()->id;
            }

            if (!$booking->tour_date_id) {
                $booking->tour_date_id = TourDate::factory()->create()->id;
            }

            if (!$booking->tour_id) {
                $booking->tour_id = TourDate::find($booking->tour_date_id)?->tour_id
                    ?? Tour::factory()->create()->id;
            }

            if (!$booking->company_id) {
                $booking->company_id = Tour::find($booking->tour_id)?->company_id
                    ?? Company::factory()->create()->id;
            }

            if ($booking->payment_status === PaymentStatusEnum::PAID && !$booking->paid_at) {
                $booking->paid_at = now()->subMinutes(fake()->numberBetween(1, 600));
            }

            if ($booking->payment_status === PaymentStatusEnum::PENDING && !$booking->expires_at) {
                $booking->expires_at = now()->addMinutes(fake()->numberBetween(5, 30));
            }
        });
    }
}
