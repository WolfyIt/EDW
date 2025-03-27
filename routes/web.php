<?php

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Private\OrderController;
use App\Http\Controllers\Private\UserController;

// Public routes
Route::get('/home', function () {
    return view('public.home');
})->name('home');

// Order search routes
Route::get('/order/search', function () {
    return view('public.orders.search');
})->name('order.search.form');

Route::get('/order/search/result', function (Request $request) {
    $customer_number = $request->input('customer_number');
    $invoice_number = $request->input('invoice_number');

    $order = Order::where('customer_number', $customer_number)
                  ->where('invoice_number', $invoice_number)
                  ->first();

    if ($order) {
        return view('public.orders.search', compact('order'));
    } else {
        return redirect()->route('order.search.form')->with('error', 'Order not found.');
    }
})->name('order.search');

// Private routes (authenticated users)
Route::middleware('auth')->group(function () {
    // Dashboard route
    Route::get('/private/dashboard', function () {
        return view('private.dashboard');
    })->name('private.dashboard');
    
    // Order management routes
    Route::get('/private/orders', [OrderController::class, 'index'])->name('private.orders.index');
    Route::get('/private/orders/{id}', [OrderController::class, 'show'])->name('private.orders.show');
    Route::get('/private/orders/{id}/edit', [OrderController::class, 'edit'])->name('private.orders.edit');  // Ruta para editar orden
    Route::put('/private/orders/{id}', [OrderController::class, 'update'])->name('private.orders.update'); // Ruta para actualizar orden
    Route::delete('/private/orders/{id}', [OrderController::class, 'destroy'])->name('private.orders.destroy'); // Ruta para eliminar orden
    
    // User management routes
    Route::get('/private/users', [UserController::class, 'index'])->name('private.users.index');
    Route::get('/private/users/create', [UserController::class, 'create'])->name('private.users.create');
    Route::post('/private/users', [UserController::class, 'store'])->name('private.users.store');
    Route::get('/private/users/{user}/edit', [UserController::class, 'edit'])->name('private.users.edit');
    Route::put('/private/users/{user}', [UserController::class, 'update'])->name('private.users.update');
    Route::delete('/private/users/{user}', [UserController::class, 'destroy'])->name('private.users.destroy');

    // Add route for user profile
    Route::get('/private/users/{user}/profile', [UserController::class, 'profile'])->name('private.users.profile');
});

