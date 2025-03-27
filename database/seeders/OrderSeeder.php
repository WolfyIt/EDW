<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;

class OrderSeeder extends Seeder
{
    public function run()
    {
        Order::create([
            'order_number' => 'ORD-62771',
            'customer_number' => 'CUS-03037',
            'invoice_number' => 'INV-04850',
            'customer_name' => 'Bernice Bosco',
            'fiscal_data' => 'Runolfsson, Emard and Rohan',
            'order_date' => '2025-01-29 07:10:02',
            'delivery_address' => '229 Summer Rest Suite 223 Funkton, FL 86346',
            'status' => 'Ordered',  // o cualquier valor válido
            'user_id' => 2,
        ]);
    }
}




