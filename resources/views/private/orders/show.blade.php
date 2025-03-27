<!-- resources/views/private/orders/show.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details - Halcon</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <style>
        :root {
            --primary-color: #000000;
            --secondary-color: #86868b;
            --accent-color: #0066cc;
            --background-color: #ffffff;
            --border-color: #d2d2d7;
            --hover-color: #f5f5f7;
            --success-color: #34c759;
            --error-color: #ff3b30;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            line-height: 1.5;
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

        .nav-links {
            display: flex;
            gap: 2rem;
        }

        .nav-link {
            text-decoration: none;
            color: var(--secondary-color);
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
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

        .page-subtitle {
            color: var(--secondary-color);
            font-size: 1.1rem;
        }

        .order-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .order-section {
            margin-bottom: 2rem;
        }

        .order-section:last-child {
            margin-bottom: 0;
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--primary-color);
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            font-size: 0.9rem;
            color: var(--secondary-color);
            margin-bottom: 0.5rem;
        }

        .info-value {
            font-size: 1.1rem;
            font-weight: 500;
            color: var(--primary-color);
        }

        .status-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .status-ordered {
            background-color: #e8f5e9;
            color: #2e7d32;
        }

        .status-processing {
            background-color: #e3f2fd;
            color: #1976d2;
        }

        .status-shipped {
            background-color: #fff3e0;
            color: #f57c00;
        }

        .status-delivered {
            background-color: #e8eaf6;
            color: #3f51b5;
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
            font-size: 0.9rem;
            font-weight: 500;
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

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
                margin-top: 60px;
            }

            .page-title {
                font-size: 2rem;
            }

            .nav {
                padding: 1rem;
            }

            .nav-links {
                display: none;
            }

            .order-card {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <nav class="nav">
        <a href="{{ route('private.dashboard') }}" class="nav-logo">Halcon</a>
        <div class="nav-links">
            <a href="{{ route('private.orders.index') }}" class="nav-link">Orders</a>
            <a href="{{ route('private.users.index') }}" class="nav-link">Users</a>
        </div>
    </nav>

    <div class="container">
        <div class="page-header">
            <a href="{{ route('private.orders.index') }}" class="back-button">
                ← Back to Orders
            </a>
            <h1 class="page-title">Order Details</h1>
            <p class="page-subtitle">View detailed information about this order</p>
        </div>

        <div class="order-card">
            <div class="order-section">
                <h2 class="section-title">Order Information</h2>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Invoice Number</span>
                        <span class="info-value">{{ $order->invoice_number }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Order Date</span>
                        <span class="info-value">
                            @if($order->order_date instanceof \Carbon\Carbon)
                                {{ $order->order_date->format('M d, Y') }}
                            @else
                                {{ $order->order_date }}
                            @endif
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Status</span>
                        <span class="status-badge status-{{ strtolower($order->status) }}">
                            {{ $order->status }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="order-section">
                <h2 class="section-title">Customer Information</h2>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Customer Name</span>
                        <span class="info-value">{{ $order->customer_name }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Customer Number</span>
                        <span class="info-value">{{ $order->customer_number }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Delivery Address</span>
                        <span class="info-value">{{ $order->delivery_address }}</span>
                    </div>
                </div>
            </div>

            @if($order->notes)
            <div class="order-section">
                <h2 class="section-title">Additional Notes</h2>
                <div class="info-item">
                    <span class="info-value">{{ $order->notes }}</span>
                </div>
            </div>
            @endif
        </div>
    </div>
</body>
</html>


