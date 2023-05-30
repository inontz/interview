<?php

namespace Database\Seeders;

use App\Models\UserAddress;
use Illuminate\Database\Seeder;

class UserAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserAddress::factory()
            ->count(1)
            ->forUser([
                'role' => 'viewer',
            ])
            ->create();
    }
}
