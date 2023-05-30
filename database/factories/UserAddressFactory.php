<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\UserAddress;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserAddress>
 */
class UserAddressFactory extends Factory
{
    protected $model = UserAddress::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'address_line_1' => fake()->address(),
            'address_line_2' => fake()->state(),
            'city' => fake()->city(),
            'postal_code' => fake()->secondaryAddress(),
            'country' => fake()->country(),
            'tel_phone' => fake()->phoneNumber(),
            'tax_request' => false,
            'tax_identification' => null,
            'tax_address_line_1' => null,
            'tax_address_line_2' => null,
            'tax_city' => null,
            'tax_postal_code' => null,
            'tax_country' => null,
            'tax_tel_phone' => null,
        ];
    }
}
