<?php

// database/seeders/UsersSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user is created by AdminUserSeeder.php, so we don't create it here.
        // However, we can log if the admin role isn't found for some reason, though RolesSeeder should handle its creation.
        $adminRole = Role::where('name', 'Admin')->first(); // Note: Case sensitive, ensure it matches RolesSeeder
        if (!$adminRole) {
            $message = 'Admin role not found. Please ensure RolesSeeder has run and defines an "Admin" role.';
            Log::error($message);
            if ($this->command) {
                $this->command->error($message);
            }
            // Optionally, you might want to return or throw an exception if admin role is critical here
        }

        $rolesToSeed = [
            'Sales' => 'sales@halcon.test',
            'Purchasing' => 'purchasing@halcon.test',
            'Warehouse' => 'warehouse@halcon.test',
            'Route' => 'route@halcon.test',
        ];

        foreach ($rolesToSeed as $roleName => $email) {
            $role = Role::where('name', $roleName)->first();
            if ($role) {
                User::updateOrCreate(
                    ['email' => $email],
                    [
                        'name' => $roleName . ' User',
                        'password' => Hash::make('password123'), // Use a secure, consistent password for seeded users
                        'role_id' => $role->id,
                        'email_verified_at' => now(),
                    ]
                );
            } else {
                $message = $roleName . ' role not found. Please ensure RolesSeeder has run and defines this role.';
                Log::warning($message);
                if ($this->command) {
                    $this->command->warn($message);
                }
            }
        }

        if ($this->command) {
            $this->command->info('Users (Sales, Purchasing, Warehouse, Route) seeded successfully if their roles existed.');
        }
    }
}



