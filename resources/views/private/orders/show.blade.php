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
            gap: 1.5rem;
            align-items: center;
        }

        .nav-link {
            text-decoration: none;
            color: var(--secondary-color);
            font-size: 0.9rem;
            transition: all 0.3s ease;
            padding: 0.5rem 0.8rem;
            border-radius: 8px;
            background-color: transparent;
        }

        .nav-link:hover {
            color: var(--primary-color);
            background-color: var(--hover-color);
            transform: translateY(-2px);
        }
        
        .nav-link-active {
            color: var(--primary-color);
            font-weight: 500;
        }
        
        .logout-link {
            color: var(--accent-color);
            background-color: rgba(0, 102, 204, 0.1);
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 500;
        }
        
        .logout-link:hover {
            background-color: rgba(0, 102, 204, 0.2);
        }
        
        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 500;
            font-size: 14px;
            margin-left: 1rem;
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
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 2rem 3rem;
            margin-bottom: 1rem;
        }

        .info-item {
            display: flex;
            flex-direction: column;
            padding: 1rem;
            background-color: #f9f9f9;
            border-radius: 10px;
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

        .status-pending {
            background-color: #fff3e0;
            color: #f57c00;
        }

        .status-processing {
            background-color: #e3f2fd;
            color: #1976d2;
        }

        .status-shipped {
            background-color: #fff8e1;
            color: #f57c00;
        }

        .status-delivered {
            background-color: #e8eaf6;
            color: #3f51b5;
        }

        .status-completed {
            background-color: #e8f5e9;
            color: #2e7d32;
        }

        .status-cancelled {
            background-color: #ffebee;
            color: #c62828;
        }

        /* Divider between sections */
        .section-divider {
            margin: 2rem 0;
            border: none;
            height: 2px;
            background-color: var(--border-color);
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
            @if(Auth::user()->role && in_array(strtolower(Auth::user()->role->name), ['admin', 'warehouse', 'sales', 'purchasing', 'route']))
                <a href="{{ route('private.orders.index') }}" class="nav-link nav-link-active">Orders</a>
            @endif
            @if(Auth::user()->role && in_array(strtolower(Auth::user()->role->name), ['admin', 'warehouse', 'purchasing']))
                <a href="{{ route('private.products.index') }}" class="nav-link">Products</a>
            @endif
            @if(Auth::user()->role && strtolower(Auth::user()->role->name) === 'admin')
                <a href="{{ route('private.users.index') }}" class="nav-link">Users</a>
                <a href="{{ route('private.customers.index') }}" class="nav-link">Customers</a>
            @endif
            {{-- Logout Link --}}
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                            this.closest('form').submit();"
                   class="nav-link logout-link">
                    Logout
                </a>
            </form>
            <div class="user-avatar" style="background-color: {{ '#' . substr(md5(Auth::user()->name), 0, 6) }}">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
        </div>
    </nav>
        </div>
    </nav>

    <div class="container">
        <div class="page-header">
            <a href="{{ route('private.orders.index') }}" class="back-button">← Back to Orders</a>
            <h1 class="page-title">Order Details</h1>
            <p class="page-subtitle">View detailed information about this order</p>
        </div>
        
        <!-- Order Photos Section -->
        <div class="orders-photos-section" style="margin:1.5rem 0;">
            <h2 class="section-title" style="margin-bottom: 1rem;">Order Photos</h2>
            <div style="display: flex; gap: 1.5rem; flex-wrap: wrap;">
                <!-- Processing Photo -->
                <div class="order-card photo-card" style="flex: 1; min-width: 300px; padding: 1.5rem;">
                    <h3 style="margin-bottom: 1rem; font-size: 1.2rem; font-weight: 500; color: var(--secondary-color);">
                        Processing Photo
                    </h3>
                    
                    @if($order->image_path)
                        <img src="{{ asset('storage/' . $order->image_path) }}" alt="Order Processing Image" 
                             style="width:100%; border-radius:10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                    @else
                        <div style="padding: 3rem; background-color: #f8f9fa; border-radius: 10px; border: 1px dashed var(--border-color);">
                            <p style="color: var(--secondary-color); font-style: italic; text-align: center;">No processing photo available</p>
                            @if($order->status == 'pending' || $order->status == 'processing')
                                <p style="font-size: 0.85rem; margin-top: 0.5rem; color: var(--secondary-color); text-align: center;">
                                    A processing photo can be added by editing this order
                                </p>
                            @endif
                        </div>
                    @endif
                </div>
                
                <!-- Delivery Photo -->
                <div class="order-card photo-card" style="flex: 1; min-width: 300px; padding: 1.5rem;">
                    <h3 style="margin-bottom: 1rem; font-size: 1.2rem; font-weight: 500; color: var(--secondary-color);">
                        Delivery Confirmation
                    </h3>
                    
                    @if($order->photo_delivered)
                        <img src="{{ asset('storage/' . $order->photo_delivered) }}" alt="Order Delivery Image" 
                             style="width:100%; border-radius:10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                    @else
                        <div style="padding: 3rem; background-color: #f8f9fa; border-radius: 10px; border: 1px dashed var(--border-color);">
                            <p style="color: var(--secondary-color); font-style: italic; text-align: center;">No delivery photo available</p>
                            @if($order->status === 'completed')
                                <p style="font-size: 0.85rem; margin-top: 0.5rem; color: var(--secondary-color); text-align: center;">
                                    A delivery photo can be added by editing this order
                                </p>
                            @else
                                <p style="font-size: 0.85rem; margin-top: 0.5rem; color: var(--secondary-color); text-align: center;">
                                    Delivery photo can be added when order is completed
                                </p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
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
                        <span class="info-label">Order Number</span>
                        <span class="info-value">{{ $order->order_number }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Order Date</span>
                        <span class="info-value">{{ $order->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Status</span>
                        <span class="status-badge status-{{ strtolower($order->status) }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>
            </div>
            <hr class="section-divider" />
            <div class="order-section">
                <h2 class="section-title">Customer Information</h2>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Customer Name</span>
                        <span class="info-value">{{ $order->customer->name }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Customer Number</span>
                        <span class="info-value">{{ $order->customer_number }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Delivery Address</span>
                        <span class="info-value">{{ $order->customer->address }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Assigned To</span>
                        <span class="info-value">{{ optional($order->user)->name ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>
            <hr class="section-divider" />
            <div class="order-section">
                <h2 class="section-title">Products</h2>
                <table class="product-table" style="width:100%;border-collapse:collapse;">
                    <thead>
                        <tr>
                            <th style="border-bottom:1px solid var(--border-color);text-align:left;padding:0.5rem;">Name</th>
                            <th style="border-bottom:1px solid var(--border-color);text-align:right;padding:0.5rem;">Qty</th>
                            <th style="border-bottom:1px solid var(--border-color);text-align:right;padding:0.5rem;">Unit Price</th>
                            <th style="border-bottom:1px solid var(--border-color);text-align:right;padding:0.5rem;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->products as $product)
                        <tr>
                            <td style="padding:0.5rem 0;">{{ $product->name }}</td>
                            <td style="padding:0.5rem 0;text-align:right;">{{ $product->pivot->quantity }}</td>
                            <td style="padding:0.5rem 0;text-align:right;">${{ number_format($product->pivot->price,2) }}</td>
                            <td style="padding:0.5rem 0;text-align:right;">${{ number_format($product->pivot->quantity * $product->pivot->price,2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" style="text-align:right;padding:0.5rem;font-weight:600;">Total:</td>
                            <td style="padding:0.5rem;text-align:right;font-weight:600;">${{ number_format($order->total_amount,2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <hr class="section-divider" />
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


