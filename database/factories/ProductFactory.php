<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\ProductCategory;
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

        return [
            'name' => fake()->numerify('product-####'),
            'desc' => fake()->text(),
            'price' => fake()->randomFloat(2, 0, 8),
            'stock' => fake()->randomNumber(),
            'category_id' => ProductCategory::all()->random()->id,
            'user_id' => User::whereIn('role', array('role' => 'admin', 'role' => 'editor'))->get()->random()->id,
        ];
    }
}
