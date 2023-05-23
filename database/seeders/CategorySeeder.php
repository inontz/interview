<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'cat01',
        ]);
        Category::create([
            'name' => 'cat02',
        ]);
        Category::create([
            'name' => 'cat03',
        ]);
        Category::create([
            'name' => 'cat04',
        ]);
    }
}
