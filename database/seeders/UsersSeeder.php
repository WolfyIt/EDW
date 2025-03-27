<?php

// database/seeders/UsersSeeder.php
namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        // Crear roles si no existen
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $userRole = Role::firstOrCreate(['name' => 'User']);

        // Crear el usuario de prueba con el rol "Admin"
        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com', // Asegúrate de que este correo sea único
            'password' => bcrypt('password'), // Cambia esto a una contraseña segura
            'role_id' => 3, // O el valor adecuado para el role_id
        ]);
    }
}



