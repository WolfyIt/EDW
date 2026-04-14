<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;  // import Role model

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure an Admin role exists
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);

        // Avoid duplicating admin user
        if (User::where('email', 'admin@halcon.test')->exists()) {
            return;
        }

        User::create([
            'name'     => 'Admin Halcon',
            'email'    => 'admin@halcon.test',
            'password' => bcrypt('secret123'),
            'role_id'  => $adminRole->id,      // assign admin role
        ]);
    }
}