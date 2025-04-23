<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed the default admin user
        $this->call(AdminUserSeeder::class);

        $this->call([
            RolesSeeder::class,
            UsersSeeder::class,
            ProductsSeeder::class,
            CustomersSeeder::class,
            OrdersSeeder::class,
        ]);
    }
}



