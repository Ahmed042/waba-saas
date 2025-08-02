<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create a default user (if it doesn't exist)
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@rubatt.com',
            'password' => bcrypt('admin123'), // clearly set password
        ]);

        // Call RolesSeeder
        $this->call(RolesSeeder::class);
    }
}
