<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductInventory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $catIds = ProductCategory::all()->pluck('id');
        $IntvIds = ProductInventory::all()->pluck('id');

        return [
            'name' => $this->faker->numerify('Product ###??'),
            'desc' => $this->faker->text,
            'price' => $this->faker->randomFloat(2, 0, 999999),
        ];
    }
}
