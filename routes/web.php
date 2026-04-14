<?php

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Private\OrderController;
use App\Http\Controllers\Private\UserController;
use App\Http\Controllers\Private\ProductController;
use App\Http\Controllers\Private\CustomerController;
use App\Http\Controllers\Private\DashboardController;

// Include authentication routes
require __DIR__.'/auth.php';

// Redirect root to /home
Route::get('/', function () {
    return redirect()->route('home');
});

// Public routes
Route::get('/home', function () {
    return view('public.home');
})->name('home');

// Order search routes
Route::get('/order/search', function () {
    try {
        // Get most recent orders for quick search
        $recentOrders = Order::latest()->take(5)->get();
        
        return view('public.orders.search', compact('recentOrders'));
    } catch (\Exception $e) {
        // If database error occurs, provide empty collection
        $recentOrders = collect([]);
        return view('public.orders.search', compact('recentOrders'))
            ->with('error', 'Unable to retrieve recent orders. Database connection issue.');
    }
})->name('order.search.form');

Route::get('/order/search/result', function (Request $request) {
    try {
        // Get most recent orders for the search form
        $recentOrders = Order::latest()->take(5)->get();
        
        // Get search inputs
        $customer_number = $request->input('customer_number');
        $invoice_number = $request->input('invoice_number');
        $order_number = $request->input('order_number');
        
        // Build the query to find the order
        $query = Order::query();
        
        if (!empty($customer_number)) {
            $query->where('customer_number', 'like', "%{$customer_number}%");
        }
        
        if (!empty($invoice_number)) {
            $query->where('invoice_number', 'like', "%{$invoice_number}%");
        }
        
        if (!empty($order_number)) {
            $query->where('order_number', 'like', "%{$order_number}%");
        }
        
        // Load relationships for complete order information
        $query->with(['customer', 'products']);
        
        // Get the first matching order
        $order = $query->first();
        
        if ($order) {
            return view('public.orders.search', compact('order', 'recentOrders'));
        } else {
            return redirect()->route('order.search.form')
                ->with('error', 'Order not found. Please check your search criteria and try again.')
                ->withInput();
        }
    } catch (\Exception $e) {
        return redirect()->route('order.search.form')
            ->with('error', 'An error occurred while searching for orders: ' . $e->getMessage())
            ->withInput();
    }
})->name('order.search');

// Private routes (authenticated users)
Route::middleware(['auth'])->prefix('private')->name('private.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Routes for creating, deleting, and managing archived orders (Admin, Warehouse, Sales, Purchasing)
    Route::middleware([\App\Http\Middleware\RoleMiddleware::class . ':admin,warehouse,sales,purchasing'])->group(function () {
        Route::get('orders/create', [OrderController::class, 'create'])->name('orders.create');
        Route::post('orders', [OrderController::class, 'store'])->name('orders.store');
        Route::delete('orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
        Route::get('orders-archived', [OrderController::class, 'archived'])->name('orders.archived');
        Route::post('orders/{order}/restore', [OrderController::class, 'restore'])->name('orders.restore');
    });

    // Routes for viewing and editing orders (Admin, Warehouse, Sales, Purchasing, Route)
    Route::middleware([\App\Http\Middleware\RoleMiddleware::class . ':admin,warehouse,sales,purchasing,route'])->group(function () {
        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::get('orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
        Route::put('orders/{order}', [OrderController::class, 'update'])->name('orders.update');
    });

    // Products routes (Admin, Warehouse, Purchasing)
    Route::middleware([\App\Http\Middleware\RoleMiddleware::class . ':admin,warehouse,purchasing'])->group(function () {
        Route::resource('products', ProductController::class);
    });

    // Users routes (Admin only)
    Route::middleware([\App\Http\Middleware\RoleMiddleware::class . ':admin'])->group(function () {
        Route::resource('users', UserController::class);
        Route::get('/users/{user}/profile', [UserController::class, 'profile'])->name('users.profile');
    });

    // Customers routes (Admin only)
    Route::middleware([\App\Http\Middleware\RoleMiddleware::class . ':admin'])->group(function () {
        Route::resource('customers', CustomerController::class);
    });
});

