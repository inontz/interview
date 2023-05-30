<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductInventory;

class ProductInventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductInventory::factory()
            ->count(1)
            ->forUser([
                'role' => 'admin',
                'role' => 'editor',
            ])
            ->forproduct()
            ->create();
    }
}
