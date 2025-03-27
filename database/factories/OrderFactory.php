<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;  // Asegúrate de incluir el modelo de User
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'order_number' => 'ORD-' . $this->faker->unique()->numerify('#####'),
            'customer_number' => $this->faker->unique()->numerify('CUS-#####'),
            'invoice_number' => $this->faker->unique()->numerify('INV-#####'),
            'customer_name' => $this->faker->name(),
            'fiscal_data' => $this->faker->company(),
            'order_date' => $this->faker->dateTimeThisYear(),
            'delivery_address' => $this->faker->address(),
            'status' => $this->faker->randomElement(['shipped', 'pending', 'cancelled']),
            'user_id' => User::factory(),  // Asegúrate de que se esté asignando un usuario válido
        ];
    }
}






