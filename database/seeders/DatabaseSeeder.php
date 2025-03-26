<?php

// database/seeders/DatabaseSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Llamar al seeder de roles
        $this->call(RolesSeeder::class);

        // Llamar al seeder de usuarios
        $this->call(UsersSeeder::class);
    }
}

