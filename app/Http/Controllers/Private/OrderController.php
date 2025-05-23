<?php

namespace App\Http\Controllers\Private;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product; // Import Product model
use Illuminate\Support\Facades\DB; // Import DB facade for transactions

class OrderController extends Controller
{
    // Display active orders with filters by invoice, customer, date, status
    public function index(Request $request)
    {
        $query = Order::with('customer', 'products')->where('archived', false);
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
        
        // Ensure all totals are calculated correctly
        foreach ($orders as $order) {
            if ($order->total_amount != $order->calculateTotal()) {
                $order->updateTotal();
            }
        }
        
        return view('private.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);  // Find order by ID or fail
        
        // Ensure the total is calculated correctly
        if ($order->total_amount != $order->calculateTotal()) {
            $order->updateTotal();
        }
        
        return view('private.orders.show', compact('order'));
    }

    // Show the form to create a new order
    public function create()
    {
        $customers = Customer::all();
        $products = Product::where('stock', '>', 0)->get(); // Get available products
        return view('private.orders.create', compact('customers', 'products')); // Pass products to view
    }

    // Store a new order
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'status' => 'required|in:' . implode(',', Order::getStatuses()),
            'notes' => 'nullable|string',
            'products' => 'required|array|min:1', // Ensure at least one product is selected
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'image_processing' => 'nullable|image|max:2048', // Processing image
            'image_delivered' => 'nullable|image|max:2048',  // Delivery image
        ]);

        // Use a database transaction to ensure atomicity
        DB::beginTransaction();
        try {
            // Generate unique numbers
            $order_number = 'ORD-' . str_pad(rand(10000, 99999), 5, '0', STR_PAD_LEFT);
            while (Order::where('order_number', $order_number)->exists()) {
                $order_number = 'ORD-' . str_pad(rand(10000, 99999), 5, '0', STR_PAD_LEFT);
            }

            $invoice_number = 'INV-' . str_pad(rand(10000, 99999), 5, '0', STR_PAD_LEFT);
            while (Order::where('invoice_number', $invoice_number)->exists()) {
                $invoice_number = 'INV-' . str_pad(rand(10000, 99999), 5, '0', STR_PAD_LEFT);
            }

            // Get customer details
            $customer = Customer::findOrFail($validated['customer_id']);

            // Calculate total amount and prepare products for pivot table
            $total_amount = 0;
            $products_to_attach = [];
            foreach ($validated['products'] as $product_data) {
                $product = Product::find($product_data['id']);
                if (!$product || $product->stock < $product_data['quantity']) {
                    // Rollback and redirect with error if stock is insufficient
                    DB::rollBack();
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['products' => 'Insufficient stock for product: ' . ($product->name ?? 'ID ' . $product_data['id'])]);
                }
                $price = $product->price;
                $quantity = $product_data['quantity'];
                $subtotal = $price * $quantity;
                $total_amount += $subtotal;

                $products_to_attach[$product->id] = [
                    'quantity' => $quantity,
                    'price' => $price, // Store price at the time of order
                ];

                // Decrement stock (optional, consider race conditions if high traffic)
                // $product->decrement('stock', $quantity);
            }

            // Create the order
            $orderData = [
                'order_number' => $order_number,
                'customer_number' => $customer->customer_number, // Use customer number from customer model
                'invoice_number' => $invoice_number,
                'customer_id' => $validated['customer_id'],
                'status' => $validated['status'],
                'total_amount' => $total_amount, // Calculated total
                'notes' => $validated['notes'],
            ];

            // Handle image uploads based on status
            if ($validated['status'] === 'pending' || $validated['status'] === 'processing') {
                // For pending/processing orders, allow processing image upload
                if ($request->hasFile('image_processing') && $request->file('image_processing')->isValid()) {
                    $orderData['image_path'] = $request->file('image_processing')->store('orders', 'public');
                }
            } 
            
            if ($validated['status'] === 'completed') {
                // For completed orders, allow delivery confirmation image upload
                if ($request->hasFile('image_delivered') && $request->file('image_delivered')->isValid()) {
                    $orderData['photo_delivered'] = $request->file('image_delivered')->store('orders', 'public');
                }
            }

            $order = Order::create($orderData);

            // Attach products to the order
            $order->products()->attach($products_to_attach);

            // Commit the transaction
            DB::commit();

            return redirect()->route('private.orders.index')
                ->with('success', 'Order created successfully with number ' . $order_number);

        } catch (\Exception $e) {
            // Rollback on error
            DB::rollBack();
            \Log::error("Error creating order: " . $e->getMessage()); // Log the error
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create order. Please try again. Error: ' . $e->getMessage());
        }
    }

    // Show the form to edit an order
    public function edit(Order $order)
    {
        // Ensure the total is calculated correctly before showing the edit form
        if ($order->total_amount != $order->calculateTotal()) {
            $order->updateTotal();
        }
        
        $customers = Customer::all();
        $products = Product::where('stock', '>', 0)->get(); // Get available products
        return view('private.orders.edit', compact('order', 'customers', 'products'));
    }

    // Update an existing order
    public function update(Request $request, Order $order)
    {
        // Check if we're only updating photos
        $isOnlyPhotoUpload = !$request->has('total_amount') && 
            ($request->hasFile('image_processing') || $request->hasFile('image_delivered'));
        
        // Different validation rules based on what's being updated
        if ($isOnlyPhotoUpload) {
            // Minimal validation for photo-only updates
            $rules = [
                'status'           => 'required|in:' . implode(',', Order::getStatuses()),
                'customer_id'      => 'required|exists:customers,id',
                'image_processing' => 'nullable|image|max:2048',
                'image_delivered'  => 'nullable|image|max:2048',
            ];
        } else {
            // Full validation for regular updates
            $rules = [
                'order_number'     => 'required|unique:orders,order_number,' . $order->id,
                'customer_id'      => 'required|exists:customers,id',
                'status'           => 'required|in:' . implode(',', Order::getStatuses()),
                'total_amount'     => 'required|numeric|min:0',
                'notes'            => 'nullable|string',
                'image_processing' => 'nullable|image|max:2048', // Processing image
                'image_delivered'  => 'nullable|image|max:2048', // Delivery confirmation image
            ];
        }
        
        $data = $request->validate($rules);
        
        // Get customer details
        $customer = Customer::findOrFail($data['customer_id']);
        
        // Add customer_number from the selected customer
        $data['customer_number'] = $customer->customer_number;
        
        // Keep the original invoice_number
        $data['invoice_number'] = $order->invoice_number;

        // Process regular data without images
        $order->fill($data);

        // Handle processing image upload if provided
        if ($request->hasFile('image_processing') && $request->file('image_processing')->isValid()) {
            // Only allow processing image upload for pending or processing orders
            if (in_array($order->status, ['pending', 'processing'])) {
                $imagePath = $request->file('image_processing')->store('orders', 'public');
                $order->image_path = $imagePath;
            }
        }
        
        // Handle delivery image upload if provided
        if ($request->hasFile('image_delivered') && $request->file('image_delivered')->isValid()) {
            // Only allow delivery image upload for completed orders
            if ($order->status === 'completed') {
                $imagePath = $request->file('image_delivered')->store('orders', 'public');
                $order->photo_delivered = $imagePath;
            }
        }

        // Save the updated order
        $order->save();
        
        // Recalculate the total amount
        if (isset($request->products) && is_array($request->products)) {
            // If the products were updated, update the pivot table and recalculate
            DB::beginTransaction();
            try {
                // First detach all existing products
                $order->products()->detach();
                
                // Then attach the new products
                $products_to_attach = [];
                foreach ($request->products as $product_data) {
                    $product = Product::find($product_data['id']);
                    if ($product) {
                        $products_to_attach[$product->id] = [
                            'quantity' => $product_data['quantity'],
                            'price' => $product->price,
                        ];
                    }
                }
                
                // Attach products to the order
                $order->products()->attach($products_to_attach);
                
                // Update the total
                $order->updateTotal();
                
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Failed to update order products. Error: ' . $e->getMessage());
            }
        } else {
            // If no products were updated, just make sure the total is correct
            $order->updateTotal();
        }

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


