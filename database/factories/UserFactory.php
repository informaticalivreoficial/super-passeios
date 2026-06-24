<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'cpf' => fake()->cpf,
            'rg' => fake()->rg,
            'birthday' => $this->faker->dateTimeBetween('-60 years', '-18 years')->format('Y-m-d'),
            'gender'     => $this->faker->randomElement(['masculino', 'feminino']),
            'zipcode' => fake()->randomNumber(8),
            'street'        => $this->faker->streetName(),
            'city'          => $this->faker->city(),
            'state'         => fake()->regionAbbr(),
            'complement'    => $this->faker->secondaryAddress(),
            'cell_phone'    => fake()->cellphoneNumber,
            'whatsapp'      => fake()->cellphoneNumber,
            'additional_email' => fake()->safeEmail(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'status' => $this->faker->boolean(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
