<?php

namespace App\Http\Controllers\Private;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;

class OrderController extends Controller
{
    // Display all orders
    public function index()
    {
        $orders = Order::with('customer')->get();
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
        $customers = Customer::all();
        return view('private.orders.create', compact('customers'));
    }

    // Store a new order
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_number' => 'required|unique:orders',
            'customer_id' => 'required|exists:customers,id',
            'invoice_number' => 'required|unique:orders',
            'status' => 'required|in:' . implode(',', Order::getStatuses()),
            'total_amount' => 'required|numeric|min:0',
            'notes' => 'nullable',
        ]);

        // Obtener el cliente y usar su nombre como customer_number
        $customer = Customer::findOrFail($validated['customer_id']);
        $validated['customer_number'] = $customer->name;

        Order::create($validated);

        return redirect()->route('private.orders.index')
            ->with('success', 'Orden creada exitosamente.');
    }

    // Show the form to edit an order
    public function edit(Order $order)
    {
        return view('private.orders.edit', compact('order'));
    }

    // Update an existing order
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'order_number' => 'required|unique:orders,order_number,' . $order->id,
            'customer_number' => 'required',
            'invoice_number' => 'required|unique:orders,invoice_number,' . $order->id,
            'status' => 'required|in:' . implode(',', Order::getStatuses()),
            'total_amount' => 'required|numeric|min:0',
            'notes' => 'nullable',
        ]);

        $order->update($validated);

        return redirect()->route('private.orders.index')
            ->with('success', 'Orden actualizada exitosamente.');
    }

    // Delete an order
    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('private.orders.index')
            ->with('success', 'Orden eliminada exitosamente.');
    }
}


