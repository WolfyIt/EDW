<?php

namespace Database\Factories;

use App\Models\OrderDetail;
use App\Models\Order;
use App\Models\Product;  // Asegúrate de importar el modelo Product
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderDetailFactory extends Factory
{
    protected $model = OrderDetail::class;

    public function definition()
    {
        return [
            'order_id' => Order::factory(),  // Relación con Order
            'product_id' => Product::factory(),  // Relación con Product
            'quantity' => $this->faker->numberBetween(1, 10),
            'price' => $this->faker->randomFloat(2, 5, 100),
            // Ya no necesitas 'product_name' si lo tienes en Product
        ];
    }
}

