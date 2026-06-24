<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->name();

        return [
            'company_id' => Company::inRandomOrder()->first()?->id ?? Company::factory(),

            /** access */
            'password'           => Hash::make('password'),
            'remember_token'     => Str::random(10),
            'email_verified_at'  => now(),
            'magic_token'        => null,
            'magic_token_expires_at' => null,

            /** personal */
            'name'       => $name,
            'email'      => $this->faker->unique()->safeEmail(),
            'phone'      => $this->faker->numerify('(##) ####-####'),
            'cell_phone' => $this->faker->numerify('(##) #####-####'),
            'cpf'   => $this->faker->cpf(false), // sem máscara
            'birthday' => $this->faker->dateTimeBetween('-60 years', '-18 years')->format('Y-m-d'),
            'gender'     => $this->faker->randomElement(['masculino', 'feminino']),
            'avatar'     => null,
            'status'     => true,

            /** address */
            'zipcode'      => $this->faker->numerify('########'),
            'street'       => $this->faker->streetName(),
            'number'       => $this->faker->buildingNumber(),
            'complement'   => $this->faker->secondaryAddress(),
            'neighborhood' => $this->faker->word(),
            'city'         => $this->faker->city(),
            'state'        => $this->faker->stateAbbr(),
        ];
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => now(),
        ]);
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
