<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Department;  // Asegúrate de importar el modelo de Department
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'),  // Asegúrate de poner la contraseña encriptada
            'role_id' => \App\Models\Role::factory(),  // Si estás usando roles
            'department_id' => Department::factory(),  // Crear un departamento relacionado
            'email_verified_at' => now(),
            'remember_token' => \Str::random(10),
        ];
    }
}



