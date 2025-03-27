<?php

// database/seeders/RolesSeeder.php
namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    public function run()
    {
        // Usar la factory para crear roles automáticamente
        Role::factory(2)->create(); // Crea 2 roles aleatorios
    }
}

