<?php

namespace App\Http\Controllers\Private;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;

class OrderController extends Controller
{
    // Display active orders with filters by invoice, customer, date, status
    public function index(Request $request)
    {
        $query = Order::with('customer')->where('archived', false);
        if ($request->filled('invoice')) {
            $query->where('invoice_number', 'like', '%'.$request->invoice.'%');
        }
        if ($request->filled('customer')) {
            $query->where('customer_number', 'like', '%'.$request->customer.'%');
        }
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $orders = $query->orderByDesc('created_at')->get();
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
        $rules = [
            'order_number'   => 'required|unique:orders,order_number,' . $order->id,
            'customer_number'=> 'required|string',
            'invoice_number' => 'required|unique:orders,invoice_number,' . $order->id,
            'status'         => 'required|in:' . implode(',', Order::getStatuses()),
            'total_amount'   => 'required|numeric|min:0',
            'notes'          => 'nullable|string',
            'photo_route'    => 'nullable|image|max:2048',
            'photo_delivered'=> 'nullable|image|max:2048',
        ]; 
        $data = $request->validate($rules);

        if ($request->hasFile('photo_route')) {
            $data['photo_route'] = $request->file('photo_route')->store('orders', 'public');
        }
        if ($request->hasFile('photo_delivered')) {
            $data['photo_delivered'] = $request->file('photo_delivered')->store('orders', 'public');
        }

        $order->update($data);

        return redirect()->route('private.orders.index')
            ->with('success', 'Order updated successfully.');
    }

    // Delete an order logically (archive)
    public function destroy(Order $order)
    {
        $order->update(['archived' => true]);
        return redirect()->route('private.orders.index')
            ->with('success', 'Order archived successfully.');
    }

    // Display archived orders
    public function archived()
    {
        $orders = Order::with('customer')->where('archived', true)->orderByDesc('created_at')->get();
        return view('private.orders.archived', compact('orders'));
    }

    // Restore an archived order
    public function restore($id)
    {
        $order = Order::findOrFail($id);
        $order->update(['archived' => false]);
        return redirect()->route('private.orders.archived')
            ->with('success', 'Order restored successfully.');
    }
}


