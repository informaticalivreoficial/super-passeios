<?php

namespace Tests\Feature\Api\V1;

use App\Enums\BookingStatusEnum;
use App\Enums\PaymentStatusEnum;
use App\Enums\TourDateStatusEnum;
use App\Models\Booking;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Tour;
use App\Models\TourDate;
use App\Services\PagBankService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_customer_can_list_own_bookings(): void
    {
        $customer = Customer::factory()->create();
        $company = Company::factory()->create();
        $tour = Tour::factory()->create(['company_id' => $company->id]);
        $tourDate = TourDate::factory()->create(['tour_id' => $tour->id]);

        Booking::factory()->count(2)->create([
            'customer_id' => $customer->id,
            'tour_id' => $tour->id,
            'tour_date_id' => $tourDate->id,
        ]);

        // Reserva de outro customer, não deve aparecer
        $otherCustomer = Customer::factory()->create();
        Booking::factory()->create([
            'customer_id' => $otherCustomer->id,
            'tour_id' => $tour->id,
            'tour_date_id' => $tourDate->id,
        ]);

        $response = $this->actingAs($customer, 'sanctum')
            ->getJson('/api/v1/bookings');

        $response->assertStatus(200);
        $this->assertCount(2, $response->json('data'));
    }

    public function test_guest_cannot_list_bookings(): void
    {
        $response = $this->getJson('/api/v1/bookings');

        $response->assertStatus(401);
    }

    public function test_customer_can_view_own_booking_by_uuid(): void
    {
        $customer = Customer::factory()->create();
        $company = Company::factory()->create();
        $tour = Tour::factory()->create(['company_id' => $company->id]);
        $tourDate = TourDate::factory()->create(['tour_id' => $tour->id]);

        $booking = Booking::factory()->create([
            'customer_id' => $customer->id,
            'tour_id' => $tour->id,
            'tour_date_id' => $tourDate->id,
        ]);

        $response = $this->actingAs($customer, 'sanctum')
            ->getJson("/api/v1/bookings/{$booking->uuid}");

        $response->assertStatus(200)
            ->assertJsonPath('data.id', $booking->id);
    }

    public function test_authenticated_customer_can_create_pix_booking_via_pagbank(): void
    {
        $customer = Customer::factory()->create();
        $company = Company::factory()->create();
        $tour = Tour::factory()->create(['company_id' => $company->id, 'active' => true]);
        $tourDate = TourDate::factory()->create([
            'tour_id' => $tour->id,
            'active' => true,
            'date' => now()->addDays(5),
            'status' => TourDateStatusEnum::OPEN,
            'available_slots' => 10,
            'price' => 100,
            'half_price' => 50,
        ]);

        $this->mock(PagBankService::class)
            ->shouldReceive('createPixPayment')
            ->once()
            ->andReturn([
                'success' => true,
                'data' => [
                    'order_id' => 'ORDE_123',
                    'qr_code' => 'PIX123',
                    'qr_code_base64' => 'BASE64',
                    'status' => 'waiting',
                ],
            ]);

        $response = $this->actingAs($customer, 'sanctum')
            ->postJson('/api/v1/bookings', [
                'tour_date_id' => $tourDate->id,
                'adults' => 2,
                'children' => 1,
                'payment_method' => 'pix',
                'name' => $customer->name,
                'email' => $customer->email,
                'cpf' => '12345678909',
                'phone' => '48999999999',
            ]);

        $response->assertStatus(201)
            ->assertJsonPath('payment.method', 'pix')
            ->assertJsonPath('payment.qr_code', 'PIX123')
            ->assertJsonPath('booking.gateway', 'pagbank');

        $this->assertDatabaseHas('bookings', [
            'customer_id' => $customer->id,
            'gateway' => 'pagbank',
            'payment_id' => 'ORDE_123',
            'payment_status' => 'PENDING',
        ]);
    }

    public function test_customer_can_cancel_own_booking(): void
    {
        $customer = Customer::factory()->create();
        $company = Company::factory()->create();
        $tour = Tour::factory()->create(['company_id' => $company->id]);
        $tourDate = TourDate::factory()->create([
            'tour_id' => $tour->id,
            'date' => now()->addDays(5),
            'status' => TourDateStatusEnum::OPEN,
            'available_slots' => 10,
        ]);
        $booking = Booking::factory()->create([
            'customer_id' => $customer->id,
            'tour_id' => $tour->id,
            'tour_date_id' => $tourDate->id,
            'status' => BookingStatusEnum::PENDING,
            'payment_status' => PaymentStatusEnum::PENDING,
        ]);

        $response = $this->actingAs($customer, 'sanctum')
            ->postJson("/api/v1/bookings/{$booking->uuid}/cancel");

        $response->assertStatus(200)
            ->assertJsonPath('data.status', 'CANCELLED');
    }

    public function test_customer_cannot_view_another_customers_booking(): void
    {
        $customer = Customer::factory()->create();
        $otherCustomer = Customer::factory()->create();

        $company = Company::factory()->create();
        $tour = Tour::factory()->create(['company_id' => $company->id]);
        $tourDate = TourDate::factory()->create(['tour_id' => $tour->id]);

        $booking = Booking::factory()->create([
            'customer_id' => $otherCustomer->id,
            'tour_id' => $tour->id,
            'tour_date_id' => $tourDate->id,
        ]);

        $response = $this->actingAs($customer, 'sanctum')
            ->getJson("/api/v1/bookings/{$booking->uuid}");

        $response->assertStatus(404);
    }
}