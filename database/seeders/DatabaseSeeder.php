<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderPhoto;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Llamar a los seeders
        $this->call([
            RolesSeeder::class,   // Crear roles primero
            UsersSeeder::class,   // Crear usuarios después
        ]);

        // Crear 10 órdenes, con sus detalles y fotos
        Order::factory(10)->create()->each(function ($order) {
            // Crea 3 detalles de productos para cada orden
            OrderDetail::factory(3)->create(['order_id' => $order->id]);

            // Crea 2 fotos para cada orden
            OrderPhoto::factory(2)->create(['order_id' => $order->id]);
        });
    }
}



