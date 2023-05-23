<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Admin1',
            'email' => 'admin1@app.com',
            'password' => bcrypt('123456'),
            'role' => 'admin',
        ]);
        $user->createToken($user->name, ['admin'])->plainTextToken;

        $user = User::create([
            'name' => 'Admin2',
            'email' => 'admin2@app.com',
            'password' => bcrypt('123456'),
            'role' => 'admin',
        ]);
        $user->createToken($user->name, ['admin'])->plainTextToken;

        $user = User::create([
            'name' => 'Admin3',
            'email' => 'admin3@app.com',
            'password' => bcrypt('123456'),
            'role' => 'admin',
        ]);
        $user->createToken($user->name, ['admin'])->plainTextToken;

        $user = User::create([
            'name' => 'Editor1',
            'email' => 'editor1@app.com',
            'password' => bcrypt('123456'),
            'role' => 'editor',
        ]);
        $user->createToken($user->name, ['editor'])->plainTextToken;

        $user = User::create([
            'name' => 'Editor2',
            'email' => 'editor2@app.com',
            'password' => bcrypt('123456'),
            'role' => 'editor',
        ]);
        $user->createToken($user->name, ['editor'])->plainTextToken;

        $user = User::create([
            'name' => 'Editor3',
            'email' => 'editor3@app.com',
            'password' => bcrypt('123456'),
            'role' => 'editor',
        ]);
        $user->createToken($user->name, ['editor'])->plainTextToken;

        $user = User::create([
            'name' => 'Viewer1',
            'email' => 'viewer1@app.com',
            'password' => bcrypt('123456'),
            'role' => 'viewer',
        ]);
        $user->createToken($user->name, ['viewer'])->plainTextToken;

        $user = User::create([
            'name' => 'Viewer2',
            'email' => 'viewer2@app.com',
            'password' => bcrypt('123456'),
            'role' => 'viewer',
        ]);
        $user->createToken($user->name, ['viewer'])->plainTextToken;

        $user = User::create([
            'name' => 'Viewer3',
            'email' => 'viewer3@app.com',
            'password' => bcrypt('123456'),
            'role' => 'viewer',
        ]);
        $user->createToken($user->name, ['viewer'])->plainTextToken;
    }
}
