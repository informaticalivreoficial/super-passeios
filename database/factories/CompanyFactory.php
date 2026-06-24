<?php

namespace Database\Factories;

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
            'uuid' => Str::uuid(),
            'api_token' => Str::random(64), 

            'responsable_name' => $this->faker->name(),
            'responsable_email' => $this->faker->email(),
            'responsable_cpf' => $this->faker->cpf(),           

            'content' => $this->faker->paragraph(),
            'url' => $this->faker->url(),
            'slug' => Str::slug($this->faker->unique()->sentence()),
            'first_year' => $this->faker->year(),
            'maps' => $this->faker->url(),

            'magic_token' => null,
            'magic_token_expires_at' => null,

            'social_name' => $this->faker->company(),
            'alias_name' => $this->faker->companySuffix(),

            'document_company' => $this->faker->cnpj,
            'document_company_secondary' => null,

            'information' => $this->faker->paragraph(),

            'status' => $this->faker->boolean(),

            // imagens
            'logo' => null,
            'metaimg' => null,

            // redes sociais
            'facebook' => $this->faker->url(),
            'twitter' => $this->faker->url(),
            'instagram' => $this->faker->url(),
            'linkedin' => $this->faker->url(),

            // endereço
            'zipcode' => $this->faker->numerify('########'),
            'street' => $this->faker->streetName(),
            'number' => $this->faker->buildingNumber(),
            'complement' => $this->faker->secondaryAddress(),
            'neighborhood' => $this->faker->word(),
            'state' => $this->faker->stateAbbr(),
            'city' => $this->faker->city(),

            // contato
            'phone' => $this->faker->numerify('##########'),
            'cell_phone' => $this->faker->numerify('###########'),
            'whatsapp' => $this->faker->numerify('###########'),
            'telegram' => $this->faker->userName(),
            'additional_email' => $this->faker->safeEmail(),
            'email' => $this->faker->unique()->safeEmail(),
        ];
    }
}
