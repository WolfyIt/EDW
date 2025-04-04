<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolesSeeder::class,
            UsersSeeder::class,
            ProductsSeeder::class,
            CustomersSeeder::class,
            OrdersSeeder::class,
        ]);
    }
}



