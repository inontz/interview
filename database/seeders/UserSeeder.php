<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->count(10) ->state(new Sequence(
                    ['role' => 'admin'],
                    ['role' => 'editor'],
                ))
                ->create();

        User::factory()->count(15) ->state(new Sequence(
                    ['role' => 'viewer'],
                ))
                // ->hasorder_items(5)
                // ->hasorder_details(1)
                ->hasaddress(1)
                ->create();

    }
}
