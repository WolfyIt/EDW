<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;

class PublicOrderController extends Controller
{
    public function search(Request $request)
    {
        $orderNumber = $request->input('order_number');
        $order = null;
        $orderProducts = null;

        if ($orderNumber) {
            $order = Order::where('order_number', $orderNumber)->first();
            
            if ($order) {
                $orderProducts = $order->products()->withPivot('quantity', 'price')->get();
            }
        }

        return view('public.orders.search', compact('order', 'orderProducts'));
    }
}




