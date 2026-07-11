<?php

namespace Tests\Feature\Api\V1;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Role::create(['name' => 'client', 'guard_name' => 'customer']);
        Role::create(['name' => 'proprietary', 'guard_name' => 'customer']);
    }

    public function test_customer_can_register(): void
    {
        $response = $this->postJson('/api/v1/register', [
            'name' => 'João Silva',
            'email' => 'joao@example.com',
            'password' => 'senha12345',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['customer' => ['id', 'name', 'email'], 'token']);

        $this->assertDatabaseHas('customers', [
            'email' => 'joao@example.com',
        ]);

        $customer = Customer::where('email', 'joao@example.com')->first();
        $this->assertTrue($customer->hasRole('client'));
    }

    public function test_register_fails_with_invalid_data(): void
    {
        $response = $this->postJson('/api/v1/register', [
            'name' => '',
            'email' => 'not-an-email',
            'password' => '123',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'password']);
    }

    public function test_register_fails_with_duplicate_email(): void
    {
        Customer::factory()->create(['email' => 'existente@example.com']);

        $response = $this->postJson('/api/v1/register', [
            'name' => 'Outro Nome',
            'email' => 'existente@example.com',
            'password' => 'senha12345',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    public function test_customer_can_login_with_correct_credentials(): void
    {
        $customer = Customer::factory()->create([
            'email' => 'joao@example.com',
            'password' => bcrypt('senha12345'),
        ]);

        $response = $this->postJson('/api/v1/login', [
            'email' => 'joao@example.com',
            'password' => 'senha12345',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['customer', 'token']);
    }

    public function test_login_fails_with_wrong_password(): void
    {
        Customer::factory()->create([
            'email' => 'joao@example.com',
            'password' => bcrypt('senha-correta'),
        ]);

        $response = $this->postJson('/api/v1/login', [
            'email' => 'joao@example.com',
            'password' => 'senha-errada',
        ]);

        $response->assertStatus(401)
            ->assertJson(['message' => 'Credenciais inválidas.']);
    }

    public function test_login_fails_with_nonexistent_email(): void
    {
        $response = $this->postJson('/api/v1/login', [
            'email' => 'naoexiste@example.com',
            'password' => 'qualquercoisa',
        ]);

        $response->assertStatus(401);
    }

    public function test_authenticated_customer_can_get_own_profile(): void
    {
        $customer = Customer::factory()->create();

        $response = $this->actingAs($customer, 'sanctum')
            ->getJson('/api/v1/me');

        $response->assertStatus(200)
            ->assertJson(['id' => $customer->id, 'email' => $customer->email]);
    }

    public function test_guest_cannot_access_protected_route(): void
    {
        $response = $this->getJson('/api/v1/me');

        $response->assertStatus(401);
    }

    public function test_customer_can_logout(): void
    {
        $customer = Customer::factory()->create();
        $token = $customer->createToken('test-token')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/v1/logout');

        $response->assertStatus(200);

        // Confirma que o token foi realmente revogado
        $this->assertDatabaseCount('personal_access_tokens', 0);
    }
}