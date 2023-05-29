<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductInventory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductInventory>
 */
class ProductInventoryFactory extends Factory
{
    protected $model = ProductInventory::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

            'quantity' => $this->faker->randomDigit,
            'product_id' => $this->faker->randomDigit,

        ];
    }
}
