<?php

namespace Tests\Feature\Api\V1;

use App\Enums\PaymentStatusEnum;
use App\Models\Booking;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Tour;
use App\Models\TourDate;
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