<?php

namespace Tests\Feature\Admin;

use App\Enums\DocumentTypeEnum;
use App\Models\Customer;
use App\Models\OperatorDocument;
use App\Models\OperatorDocumentAcceptance;
use App\Models\User;
use App\Services\OperatorDocumentService;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class OperatorDocumentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesAndPermissionsSeeder::class);
    }

    private function createAdmin(): User
    {
        $admin = User::factory()->create();
        $admin->assignRole('super-admin');
        return $admin;
    }

    private function createOperator(): Customer
    {
        $customer = Customer::factory()->create([
            'password' => bcrypt('password'),
        ]);
        $customer->assignRole('proprietary');
        return $customer;
    }

    private function createPublishedDocument(array $overrides = []): OperatorDocument
    {
        return OperatorDocument::create(array_merge([
            'type'         => DocumentTypeEnum::CONTRATO_ADESAO->value,
            'title'        => 'Contrato de Adesão',
            'slug'         => 'contrato-de-adesao-1-0',
            'content'      => '<h2>Contrato</h2><p>Conteúdo do contrato.</p>',
            'version'      => '1.0',
            'is_required'  => true,
            'is_active'    => true,
            'published_at' => now(),
            'effective_at' => now(),
        ], $overrides));
    }

    private function createDraftDocument(array $overrides = []): OperatorDocument
    {
        return OperatorDocument::create(array_merge([
            'type'        => DocumentTypeEnum::TERMO_MARCA->value,
            'title'       => 'Termo de Marca',
            'slug'        => 'termo-de-marca-1-0',
            'content'     => '<h2>Termo</h2><p>Conteúdo do termo.</p>',
            'version'     => '1.0',
            'is_required' => false,
            'is_active'   => false,
        ], $overrides));
    }

    public function test_admin_can_view_document_list(): void
    {
        $admin = $this->createAdmin();
        $this->actingAs($admin);

        Livewire::test(\App\Livewire\Dashboard\Documents\DocumentIndex::class)
            ->assertStatus(200);
    }

    public function test_operator_can_view_document_list(): void
    {
        $operator = $this->createOperator();
        $this->actingAs($operator, 'customer');

        Livewire::test(\App\Livewire\Company\Documents\DocumentIndex::class)
            ->assertStatus(200);
    }

    public function test_operator_can_view_published_document(): void
    {
        $operator = $this->createOperator();
        $document = $this->createPublishedDocument();
        $this->actingAs($operator, 'customer');

        Livewire::test(\App\Livewire\Company\Documents\DocumentShow::class, ['document' => $document])
            ->assertStatus(200)
            ->assertSee($document->title);
    }

    public function test_operator_cannot_view_draft_document(): void
    {
        $operator = $this->createOperator();
        $document = $this->createDraftDocument();
        $this->actingAs($operator, 'customer');

        Livewire::test(\App\Livewire\Company\Documents\DocumentShow::class, ['document' => $document])
            ->assertStatus(403);
    }

    public function test_operator_can_accept_document(): void
    {
        $operator = $this->createOperator();
        $document = $this->createPublishedDocument();
        $this->actingAs($operator, 'customer');

        Livewire::test(\App\Livewire\Company\Documents\DocumentShow::class, ['document' => $document])
            ->call('markAsViewed')
            ->set('agreeTerms', true)
            ->call('accept');

        $this->assertDatabaseHas('operator_document_acceptances', [
            'customer_id' => $operator->id,
            'document_id' => $document->id,
            'version'     => '1.0',
        ]);
    }

    public function test_acceptance_records_correct_version(): void
    {
        $operator = $this->createOperator();
        $document = $this->createPublishedDocument(['version' => '2.0']);
        $this->actingAs($operator, 'customer');

        Livewire::test(\App\Livewire\Company\Documents\DocumentShow::class, ['document' => $document])
            ->call('markAsViewed')
            ->set('agreeTerms', true)
            ->call('accept');

        $acceptance = OperatorDocumentAcceptance::where('customer_id', $operator->id)
            ->where('document_id', $document->id)
            ->first();

        $this->assertEquals('2.0', $acceptance->version);
    }

    public function test_acceptance_records_ip_address(): void
    {
        $operator = $this->createOperator();
        $document = $this->createPublishedDocument();

        $service = new OperatorDocumentService();
        $acceptance = $service->acceptDocument(
            $operator,
            $document,
            '192.168.1.1',
            'Mozilla/5.0'
        );

        $this->assertEquals('192.168.1.1', $acceptance->ip_address);
        $this->assertEquals('Mozilla/5.0', $acceptance->user_agent);
    }

    public function test_acceptance_records_user_agent(): void
    {
        $operator = $this->createOperator();
        $document = $this->createPublishedDocument();

        $service = new OperatorDocumentService();
        $acceptance = $service->acceptDocument(
            $operator,
            $document,
            null,
            'TestAgent/1.0'
        );

        $this->assertEquals('TestAgent/1.0', $acceptance->user_agent);
    }

    public function test_new_version_requires_new_acceptance(): void
    {
        $operator = $this->createOperator();
        $docV1 = $this->createPublishedDocument(['version' => '1.0']);
        $docV2 = $this->createPublishedDocument(['version' => '2.0']);

        $service = new OperatorDocumentService();
        $service->acceptDocument($operator, $docV1);

        $this->assertTrue($service->hasAcceptedDocument($operator, $docV1));
        $this->assertFalse($service->hasAcceptedDocument($operator, $docV2));
        $this->assertTrue($service->requiresAcceptance($operator, $docV2));
    }

    public function test_old_version_acceptance_is_preserved(): void
    {
        $operator = $this->createOperator();
        $docV1 = $this->createPublishedDocument(['version' => '1.0']);
        $docV2 = $this->createPublishedDocument(['version' => '2.0']);

        $service = new OperatorDocumentService();
        $service->acceptDocument($operator, $docV1);
        $service->acceptDocument($operator, $docV2);

        $this->assertTrue($service->hasAcceptedDocument($operator, $docV1));
        $this->assertTrue($service->hasAcceptedDocument($operator, $docV2));

        $this->assertDatabaseHas('operator_document_acceptances', [
            'customer_id' => $operator->id,
            'document_id' => $docV1->id,
            'version'     => '1.0',
        ]);
        $this->assertDatabaseHas('operator_document_acceptances', [
            'customer_id' => $operator->id,
            'document_id' => $docV2->id,
            'version'     => '2.0',
        ]);
    }

    public function test_only_admin_can_access_admin_routes(): void
    {
        $operator = $this->createOperator();
        $this->actingAs($operator, 'customer');

        $response = $this->get(route('admin.documents.index'));
        $response->assertStatus(403);
    }

    public function test_pending_required_documents_are_identified_correctly(): void
    {
        $operator = $this->createOperator();
        $service = new OperatorDocumentService();

        $this->assertFalse($service->hasPendingRequiredDocuments($operator));

        $this->createPublishedDocument(['is_required' => true]);

        $this->assertTrue($service->hasPendingRequiredDocuments($operator));
        $this->assertEquals(1, $service->getPendingRequiredCount($operator));
    }

    public function test_duplicate_acceptance_does_not_create_inconsistent_records(): void
    {
        $operator = $this->createOperator();
        $document = $this->createPublishedDocument();

        $service = new OperatorDocumentService();
        $a1 = $service->acceptDocument($operator, $document);
        $a2 = $service->acceptDocument($operator, $document);

        $this->assertEquals($a1->id, $a2->id);

        $count = OperatorDocumentAcceptance::where('customer_id', $operator->id)
            ->where('document_id', $document->id)
            ->count();

        $this->assertEquals(1, $count);
    }

    public function test_content_hash_is_computed_correctly(): void
    {
        $document = $this->createPublishedDocument();

        $expectedHash = hash('sha256', $document->content);
        $this->assertEquals($expectedHash, $document->contentHash());
    }

    public function test_operator_cannot_create_documents(): void
    {
        $operator = $this->createOperator();
        $this->actingAs($operator, 'customer');

        $response = $this->get(route('admin.documents.create'));
        $response->assertStatus(403);
    }
}
