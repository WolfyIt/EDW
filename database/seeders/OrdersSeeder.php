<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Product;

class OrdersSeeder extends Seeder
{
    public function run(): void
    {
        $customers = Customer::all();
        $products = Product::all();
        $statuses = ['pending', 'processing', 'completed', 'cancelled'];

        foreach ($customers as $customer) {
            // Crear 1-3 órdenes por cliente
            $numOrders = rand(1, 3);
            
            for ($i = 0; $i < $numOrders; $i++) {
                $order = Order::create([
                    'order_number' => 'ORD-' . str_pad(rand(10000, 99999), 5, '0', STR_PAD_LEFT),
                    'customer_number' => $customer->name,
                    'invoice_number' => 'INV-' . str_pad(rand(10000, 99999), 5, '0', STR_PAD_LEFT),
                    'customer_id' => $customer->id,
                    'status' => $statuses[array_rand($statuses)],
                    'total_amount' => rand(100, 1000),
                    'notes' => 'Nota de ejemplo para la orden ' . ($i + 1),
                ]);

                // Agregar 1-3 productos a cada orden
                $numProducts = rand(1, 3);
                $selectedProducts = $products->random($numProducts);
                
                foreach ($selectedProducts as $product) {
                    $order->products()->attach($product->id, [
                        'quantity' => rand(1, 5),
                        'price' => $product->price,
                    ]);
                }
            }
        }
    }
} 