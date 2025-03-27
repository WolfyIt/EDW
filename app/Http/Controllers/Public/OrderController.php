<?php

// app/Http/Controllers/Public/OrderController.php

namespace App\Http\Controllers\Public;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    // Display orders for public users
    public function index()
    {
        $orders = Order::all(); // You can add filtering based on public access
        return view('public.orders.index', compact('orders'));
    }

    // Show a single order publicly (if permitted)
    public function show($id)
    {
        $order = Order::findOrFail($id);
        return view('public.orders.show', compact('order'));
    }
}



