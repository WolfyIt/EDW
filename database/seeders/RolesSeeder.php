<?php

// database/seeders/RolesSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role; // Ensure Role model is imported
use Illuminate\Support\Facades\Log;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'Admin', // Though AdminUserSeeder also creates it, defining here is fine for clarity or if AdminUserSeeder changes.
            'Sales',
            'Purchasing',
            'Warehouse',
            'Route'
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        Log::info('Roles seeded successfully.');
        if ($this->command) {
            $this->command->info('Roles seeded successfully.');
        }
    }
}

