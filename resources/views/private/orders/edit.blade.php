<!-- resources/views/private/orders/edit.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order - Halcon</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <style>
        /* Similar styles to the ones in index.blade.php and show.blade.php */
        :root {
            --primary-color: #000000;
            --secondary-color: #86868b;
            --accent-color: #0066cc;
            --background-color: #ffffff;
            --border-color: #d2d2d7;
            --hover-color: #f5f5f7;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--primary-color);
            background-color: var(--background-color);
        }

        .nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            z-index: 1000;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border-color);
        }

        .nav-logo {
            font-size: 1.5rem;
            font-weight: 600;
            text-decoration: none;
            color: var(--primary-color);
        }

        .container {
            max-width: 800px;
            margin: 80px auto 0;
            padding: 2rem;
        }

        .page-header {
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            background: linear-gradient(45deg, #000000, #333333);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--primary-color);
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 1rem;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: var(--accent-color);
        }

        .form-group button {
            padding: 0.8rem 1.5rem;
            background-color: var(--accent-color);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .form-group button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 102, 204, 0.2);
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            background-color: #f8f9fa;
            color: #212529;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 1rem;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .back-button:hover {
            background-color: var(--hover-color);
            transform: translateY(-2px);
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .back-button::before {
            content: "←";
            margin-right: 0.5rem;
            font-size: 1.1rem;
        }
    </style>
</head>
<body>
    <nav class="nav">
        <a href="{{ route('private.dashboard') }}" class="nav-logo">Halcon</a>
    </nav>

    <div class="container">
        <div class="page-header">
            <a href="{{ route('private.orders.index') }}" class="back-button">
                ← Back to Orders
            </a>
            <h1 class="page-title">Edit Order</h1>
            <p class="page-subtitle">Modify the details of the order</p>
        </div>

        <form action="{{ route('private.orders.update', $order->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="invoice_number">Invoice Number</label>
                <input type="text" id="invoice_number" name="invoice_number" value="{{ old('invoice_number', $order->invoice_number) }}" required>
            </div>

            <div class="form-group">
                <label for="customer_name">Customer Name</label>
                <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name', $order->customer_name) }}" required>
            </div>

            <div class="form-group">
                <label for="status">Order Status</label>
                <select id="status" name="status" required>
                    <option value="ordered" {{ $order->status == 'ordered' ? 'selected' : '' }}>Ordered</option>
                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                </select>
            </div>

            <div class="form-group">
                <button type="submit">Update Order</button>
            </div>
        </form>
    </div>
</body>
</html>
