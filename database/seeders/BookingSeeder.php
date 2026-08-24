<?php

namespace Database\Seeders;

use App\Enums\BookingStatusEnum;
use App\Enums\PaymentStatusEnum;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\TourDate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = Customer::whereHas('roles', fn ($query) => $query->where('name', 'client'))->get();

        if ($clients->isEmpty()) {
            return;
        }

        $paymentStatuses = [
            PaymentStatusEnum::PAID,
            PaymentStatusEnum::PAID,
            PaymentStatusEnum::PAID,
            PaymentStatusEnum::PENDING,
            PaymentStatusEnum::PENDING,
            PaymentStatusEnum::REFUNDED,
            PaymentStatusEnum::REFUSED,
            PaymentStatusEnum::EXPIRED,
        ];

        TourDate::where('status', \App\Enums\TourDateStatusEnum::OPEN)
            ->where('date', '>=', now()->toDateString())
            ->get()
            ->each(function (TourDate $tourDate) use ($clients, $paymentStatuses) {
                $bookingsCount = fake()->numberBetween(0, 3);

                for ($i = 0; $i < $bookingsCount; $i++) {
                    $customer = $clients->random();
                    $maxAdults = min($tourDate->available_slots, 6);
                    $adults = fake()->numberBetween(1, max(1, $maxAdults));
                    $children = fake()->numberBetween(0, 2);
                    $childrenFree = fake()->numberBetween(0, 2);

                    $paymentStatus = fake()->randomElement($paymentStatuses);
                    $status = match ($paymentStatus) {
                        PaymentStatusEnum::PAID => BookingStatusEnum::CONFIRMED,
                        PaymentStatusEnum::PENDING => BookingStatusEnum::PENDING,
                        default => BookingStatusEnum::CANCELLED,
                    };

                    Booking::factory()->create([
                        'customer_id' => $customer->id,
                        'tour_date_id' => $tourDate->id,
                        'tour_id' => $tourDate->tour_id,
                        'company_id' => $tourDate->tour->company_id,
                        'customer_name' => $customer->name,
                        'customer_email' => $customer->email,
                        'customer_phone' => $customer->phone,
                        'adults' => $adults,
                        'children' => $children,
                        'children_free' => $childrenFree,
                        'payment_method' => fake()->randomElement(['pix', 'credit_card']),
                        'gateway' => 'pagbank',
                        'payment_status' => $paymentStatus,
                        'status' => $status,
                    ]);
                }
            });
    }
}
