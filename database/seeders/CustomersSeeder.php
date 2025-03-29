<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use Faker\Factory as Faker;

class CustomersSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('es_MX');

        // Crear 10 clientes de ejemplo
        for ($i = 0; $i < 10; $i++) {
            Customer::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->phoneNumber,
                'address' => $faker->address,
            ]);
        }
    }
} 