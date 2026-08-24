<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'responsable_name' => fake()->name(),
            'responsable_email' => fake()->safeEmail(),
            'responsable_cpf' => fake()->cpf(false),

            'content' => fake()->paragraph(),
            'url' => fake()->url(),
            'first_year' => fake()->year(),
            'maps' => fake()->url(),

            'magic_token' => null,
            'magic_token_expires_at' => null,

            'social_name' => fake()->company(),
            'alias_name' => fake()->companySuffix(),

            'document_company' => fake()->cnpj(),
            'document_company_secondary' => null,

            'information' => fake()->paragraph(),

            'status' => true,
            'commission_rate' => fake()->randomFloat(2, 5, 15),
            'release_days' => fake()->numberBetween(1, 7),

            'logo' => null,
            'metaimg' => null,

            'facebook' => fake()->url(),
            'twitter' => fake()->url(),
            'instagram' => fake()->url(),
            'linkedin' => fake()->url(),
            'tiktok' => fake()->url(),

            'zipcode' => fake()->numerify('########'),
            'street' => fake()->streetName(),
            'number' => fake()->buildingNumber(),
            'complement' => fake()->secondaryAddress(),
            'neighborhood' => fake()->word(),
            'state' => fake()->stateAbbr(),
            'city' => fake()->city(),

            'phone' => fake()->numerify('##########'),
            'cell_phone' => fake()->numerify('###########'),
            'whatsapp' => fake()->numerify('###########'),
            'telegram' => fake()->userName(),
            'additional_email' => fake()->safeEmail(),
            'email' => fake()->unique()->safeEmail(),
        ];
    }
}
