<?php

namespace Database\Factories;

use App\Models\OrderPhoto;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderPhotoFactory extends Factory
{
    protected $model = OrderPhoto::class;

    public function definition()
    {
        return [
            'order_id' => Order::factory(),  // Relación con la orden
            'photo_path' => $this->faker->imageUrl(),
            'type' => $this->faker->randomElement(['loaded', 'delivered']),
        ];
    }
}
