<?php

// database/seeders/UsersSeeder.php
namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        // Asignar el rol "Admin" a un usuario de prueba
        $role = Role::firstOrCreate(['name' => 'Admin']); // Se asegura de que el rol exista

        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),  // Asegúrate de usar bcrypt para la contraseña
            'role_id' => $role->id,  // Asigna el role_id
            'email_verified_at' => now(),  // Asegúrate de que este campo esté completo
        ]);
    }
}

