<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Customer;

class OrdersApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with(['customer','products'])->where('archived', false)->get();
        return response()->json($orders);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'order_number'   => 'required|unique:orders',
            'customer_id'    => 'required|exists:customers,id',
            'invoice_number' => 'required|unique:orders',
            'status'         => 'required|in:' . implode(',', Order::getStatuses()),
            'total_amount'   => 'required|numeric|min:0',
            'notes'          => 'nullable|string',
        ]);

        $customer = Customer::find($data['customer_id']);
        $data['customer_number'] = $customer->customer_number;

        $order = Order::create($data);
        return response()->json($order->load(['customer','products']), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order = Order::with(['customer','products'])->findOrFail($id);
        return response()->json($order);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $data = $request->validate([
            'order_number'   => 'required|unique:orders,order_number,' . $order->id,
            'customer_id'    => 'required|exists:customers,id',
            'invoice_number' => 'required|unique:orders,invoice_number,' . $order->id,
            'status'         => 'required|in:' . implode(',', Order::getStatuses()),
            'total_amount'   => 'required|numeric|min:0',
            'notes'          => 'nullable|string',
        ]);

        $customer = Customer::find($data['customer_id']);
        $data['customer_number'] = $customer->customer_number;

        $order->update($data);
        return response()->json($order->load(['customer','products']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return response()->json(null, 204);
    }
}
