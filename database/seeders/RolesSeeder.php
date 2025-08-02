<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RolesSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        Role::create(['name' => 'super_admin']);
        Role::create(['name' => 'client']);

        // Assign 'super_admin' role to your first user
        $user = User::first();
        if ($user) {
            $user->assignRole('super_admin');
        }
    }
}
