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
        $customerNumber = $request->input('customer_number');
        $invoiceNumber = $request->input('invoice_number');

        // Buscar la orden
        $order = Order::where('customer_number', $customerNumber)
                      ->where('invoice_number', $invoiceNumber)
                      ->first();

        if (!$order) {
            return back()->with('error', 'No se encontró ninguna orden con esos datos.');
        }

        // Obtener los detalles del pedido
        $orderDetails = OrderDetail::where('order_id', $order->id)
                                   ->with('product') // Relación con productos
                                   ->get();

        return view('public.orders.search', compact('order', 'orderDetails'));
    }
}




