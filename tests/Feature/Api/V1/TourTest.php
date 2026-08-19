<?php

namespace Tests\Feature\Api\V1;

use App\Enums\TourDateStatusEnum;
use App\Models\Company;
use App\Models\Tour;
use App\Models\TourDate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TourTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_active_tours_without_authentication(): void
    {
        $company = Company::factory()->create();
        Tour::factory()->count(3)->create(['company_id' => $company->id, 'active' => true]);
        Tour::factory()->create(['company_id' => $company->id, 'active' => false]);

        $response = $this->getJson('/api/v1/tours');

        $response->assertStatus(200);
        $this->assertCount(3, $response->json('data'));
    }

    public function test_can_filter_tours_by_search(): void
    {
        $company = Company::factory()->create();
        Tour::factory()->create(['company_id' => $company->id, 'active' => true, 'title' => 'Passeio de Escuna']);
        Tour::factory()->create(['company_id' => $company->id, 'active' => true, 'title' => 'Mergulho nas Ilhas']);

        $response = $this->getJson('/api/v1/tours?search=Escuna');

        $response->assertStatus(200);
        $this->assertCount(1, $response->json('data'));
        $this->assertEquals('Passeio de Escuna', $response->json('data.0.title'));
    }

    public function test_can_show_single_tour_by_slug(): void
    {
        $company = Company::factory()->create();
        $tour = Tour::factory()->create(['company_id' => $company->id, 'title' => 'Passeio Teste']);

        $response = $this->getJson("/api/v1/tours/{$tour->slug}");

        $response->assertStatus(200)
            ->assertJsonPath('data.slug', $tour->slug);
    }

    public function test_show_returns_404_for_nonexistent_slug(): void
    {
        $response = $this->getJson('/api/v1/tours/nao-existe');

        $response->assertStatus(404);
    }

    public function test_dates_endpoint_only_returns_available_dates(): void
    {
        $company = Company::factory()->create();
        $tour = Tour::factory()->create(['company_id' => $company->id]);

        // Data disponível: ativa, futura, status OPEN, com vagas
        TourDate::factory()->create([
            'tour_id' => $tour->id,
            'active' => true,
            'date' => now()->addDays(5),
            'status' => TourDateStatusEnum::OPEN,
            'available_slots' => 10,
        ]);

        // Data indisponível: lotada
        TourDate::factory()->create([
            'tour_id' => $tour->id,
            'active' => true,
            'date' => now()->addDays(3),
            'status' => TourDateStatusEnum::FULL,
            'available_slots' => 0,
        ]);

        // Data indisponível: no passado
        TourDate::factory()->create([
            'tour_id' => $tour->id,
            'active' => true,
            'date' => now()->subDays(2),
            'status' => TourDateStatusEnum::OPEN,
            'available_slots' => 5,
        ]);

        $response = $this->getJson("/api/v1/tours/{$tour->slug}/dates");

        $response->assertStatus(200);
        $this->assertCount(1, $response->json('data'));
    }
}