<?php

namespace App\Http\Controllers\Private;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    // Display all orders
    public function index()
    {
        $orders = Order::all(); // You can add pagination or filters
        return view('private.orders.index', compact('orders'));
    }

    // Show a single order
    public function show($id)
    {
        $order = Order::findOrFail($id);  // Find order by ID or fail
        return view('private.orders.show', compact('order'));
    }

    // Show the form to create a new order
    public function create()
    {
        return view('private.orders.create');
    }

    // Store a new order
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_number' => 'required|numeric',
            'invoice_number' => 'required|numeric|unique:orders',
            'order_date' => 'required|date',
            // Add any other fields you need
        ]);

        $order = Order::create($validated);

        return redirect()->route('private.orders.index')->with('success', 'Order created successfully.');
    }

    // Show the form to edit an order
    public function edit($id)
    {
        $order = Order::findOrFail($id);
        return view('private.orders.edit', compact('order'));
    }

    // Update an existing order
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'customer_number' => 'required|numeric',
            'invoice_number' => 'required|numeric|unique:orders,invoice_number,' . $id,
            'order_date' => 'required|date',
            // Add any other fields you need
        ]);

        $order->update($validated);

        return redirect()->route('private.orders.index')->with('success', 'Order updated successfully.');
    }

    // Delete an order
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('private.orders.index')->with('success', 'Order deleted successfully.');
    }
}


