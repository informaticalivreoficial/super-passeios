<?php

namespace Tests\Feature\Admin;

use App\Enums\BookingStatusEnum;
use App\Enums\PaymentStatusEnum;
use App\Livewire\Dashboard\Bookings\Bookings;
use App\Models\Booking;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Tour;
use App\Models\TourDate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class BookingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_component_renders_with_metrics(): void
    {
        $company = Company::factory()->create();
        $tour = Tour::factory()->create(['company_id' => $company->id]);
        $tourDate = TourDate::factory()->create(['tour_id' => $tour->id]);
        $customer = Customer::factory()->create();

        Booking::factory()->count(3)->create([
            'customer_id' => $customer->id,
            'tour_id' => $tour->id,
            'tour_date_id' => $tourDate->id,
        ]);

        Livewire::test(Bookings::class)
            ->assertOk()
            ->assertViewHas('bookings', fn ($bookings) => $bookings->total() === 3)
            ->assertViewHas('metrics', fn ($metrics) => $metrics['total'] === 3)
            ->assertViewHas('companies');
    }

    public function test_search_filters_bookings(): void
    {
        $company = Company::factory()->create();
        $tour = Tour::factory()->create(['company_id' => $company->id]);
        $tourDate = TourDate::factory()->create(['tour_id' => $tour->id]);
        $customer = Customer::factory()->create();

        Booking::factory()->create([
            'customer_id' => $customer->id,
            'customer_name' => 'João da Silva',
            'tour_id' => $tour->id,
            'tour_date_id' => $tourDate->id,
        ]);

        Booking::factory()->create([
            'customer_id' => $customer->id,
            'customer_name' => 'Maria Souza',
            'tour_id' => $tour->id,
            'tour_date_id' => $tourDate->id,
        ]);

        Livewire::test(Bookings::class)
            ->set('search', 'João')
            ->assertViewHas('bookings', fn ($bookings) => $bookings->total() === 1);
    }

    public function test_status_filter_filters_bookings(): void
    {
        $company = Company::factory()->create();
        $tour = Tour::factory()->create(['company_id' => $company->id]);
        $tourDate = TourDate::factory()->create(['tour_id' => $tour->id]);
        $customer = Customer::factory()->create();

        Booking::factory()->create([
            'customer_id' => $customer->id,
            'tour_id' => $tour->id,
            'tour_date_id' => $tourDate->id,
            'status' => BookingStatusEnum::CONFIRMED,
            'payment_status' => PaymentStatusEnum::PAID,
        ]);

        Booking::factory()->create([
            'customer_id' => $customer->id,
            'tour_id' => $tour->id,
            'tour_date_id' => $tourDate->id,
            'status' => BookingStatusEnum::CANCELLED,
            'payment_status' => PaymentStatusEnum::REFUSED,
        ]);

        Livewire::test(Bookings::class)
            ->set('statusFilter', BookingStatusEnum::CANCELLED->value)
            ->assertViewHas('bookings', fn ($bookings) => $bookings->total() === 1);
    }
}