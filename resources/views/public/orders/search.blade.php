<!-- resources/views/public/orders/search.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halcon - Order Search</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <style>
        :root {
            --primary-color: #000000;
            --secondary-color: #86868b;
            --accent-color: #0066cc;
            --background-color: #ffffff;
            --error-color: #ff3b30;
            --success-color: #34c759;
        }

        <!-- Helper scripts for testing -->
        <script>
            function getImageUrl(path) {
                if (!path) return null;
                // For mock data, use placeholder images
                if (path === 'orders/mockprocessing.jpg') {
                    return 'https://placehold.co/600x400/e3f2fd/1976d2?text=Processing+Photo';
                }
                if (path === 'orders/mockdelivery.jpg') {
                    return 'https://placehold.co/600x400/e8f5e9/2e7d32?text=Delivery+Photo';
                }
                return '{{ asset('storage') }}/' + path;
            }
        </script>

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
            min-height: 100vh;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
        }

        .search-header {
            text-align: center;
            margin-bottom: 3rem;
            margin-top: 2rem;
        }

        .search-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            background: linear-gradient(45deg, #000000, #333333);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .search-subtitle {
            color: var(--secondary-color);
            font-size: 1.2rem;
            max-width: 600px;
            margin: 0 auto;
        }

        .search-form {
            background: #f5f5f7;
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--primary-color);
        }

        .form-input {
            width: 100%;
            padding: 1rem;
            border: 1px solid #d2d2d7;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.1);
        }

        .search-button {
            display: block;
            width: 100%;
            padding: 1rem;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .search-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .result-section {
            margin-top: 2rem;
            padding: 2rem;
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Status badge styles */
        .status-badge {
            display: inline-block;
            padding: 0.3rem 0.6rem;
            border-radius: 12px;
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

        .result-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: var(--primary-color);
        }

        .result-item {
            display: flex;
            justify-content: space-between;
            padding: 1rem 0;
            border-bottom: 1px solid #f5f5f7;
        }

        .result-item:last-child {
            border-bottom: none;
        }

        .result-label {
            color: var(--secondary-color);
            font-weight: 500;
        }

        .result-value {
            font-weight: 600;
        }

        .error-message {
            background-color: #fff2f2;
            color: var(--error-color);
            padding: 1rem;
            border-radius: 10px;
            margin-top: 1rem;
            text-align: center;
        }

        .success-message {
            background-color: #f2fff5;
            color: var(--success-color);
            padding: 1rem;
            border-radius: 10px;
            margin-top: 1rem;
            text-align: center;
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            padding: 0.8rem 1.5rem;
            background-color: #f5f5f7;
            color: var(--primary-color);
            text-decoration: none;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
            margin-top: 2rem;
            border: 1px solid #d2d2d7;
        }

        .back-button:hover {
            background-color: #e5e5e7;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        /* New styles for products in search result */
        .result-subtitle {
            font-size: 1.2rem;
            font-weight: 600;
            margin-top: 2rem;
            margin-bottom: 1rem;
            color: var(--primary-color);
        }

        .product-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
        }

        .product-table th,
        .product-table td {
            padding: 0.5rem;
            border-bottom: 1px solid #f5f5f7;
        }

        .product-table th {
            text-align: left;
            color: var(--secondary-color);
            font-weight: 500;
        }

        .product-table td {
            text-align: right;
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .search-title {
                font-size: 2rem;
            }

            .search-subtitle {
                font-size: 1rem;
            }
        }

        /* Order Photos Styling */
        .order-photos-section {
            margin-bottom: 2rem;
        }

        .photo-card {
            transition: all 0.3s ease;
        }

        .photo-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .result-subtitle {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--primary-color);
            border-bottom: 1px solid #f0f0f0;
            padding-bottom: 0.5rem;
        }

        /* Alert message styles */
        .error-alert {
            background-color: #ffebee;
            color: #c62828;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            border-left: 4px solid #c62828;
            font-weight: 500;
        }

        .success-alert {
            background-color: #e8f5e9;
            color: #2e7d32;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            border-left: 4px solid #2e7d32;
            font-weight: 500;
        }
        
        /* Testing/Debug section styles */
        .available-orders {
            margin-top: 2rem;
            padding: 1.5rem;
            background-color: #f5f5f7;
            border-radius: 10px;
            border: 1px dashed #ccc;
        }
        
        .available-orders h3 {
            margin-bottom: 1rem;
            color: #333;
            font-size: 1.2rem;
        }
        
        .order-test-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1rem;
        }
        
        .test-order-item {
            background-color: white;
            padding: 1rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .test-order-item div {
            margin-bottom: 0.5rem;
        }
        
        .test-info {
            margin-top: 1rem;
            font-style: italic;
            color: #666;
            font-size: 0.9rem;
        }
        
        .search-tip {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="search-header">
            <h1 class="search-title">Order Search</h1>
            <p class="search-subtitle">Enter your customer number and invoice number to track your order</p>
        </div>

        @if(session('error'))
            <div class="error-alert">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="success-alert">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('order.search') }}" method="GET" class="search-form">
            <div class="form-group">
                <label for="order_number" class="form-label">Order Number</label>
                <input type="text" name="order_number" id="order_number" class="form-input" value="{{ old('order_number') }}">
            </div>
            <div class="form-group">
                <label for="customer_number" class="form-label">Customer Number</label>
                <input type="text" name="customer_number" id="customer_number" class="form-input" value="{{ old('customer_number') }}">
            </div>
            <div class="form-group">
                <label for="invoice_number" class="form-label">Invoice Number</label>
                <input type="text" name="invoice_number" id="invoice_number" class="form-input" value="{{ old('invoice_number') }}">
            </div>
            <p class="search-tip">Enter at least one search criteria above.</p>
            <button type="submit" class="search-button">Search Order</button>
        </form>

        @if(isset($order))
            <div class="result-section">
                <h2 class="result-title">Order Details</h2>
                <div class="result-item">
                    <span class="result-label">Order Number</span>
                    <span class="result-value">{{ $order->order_number }}</span>
                </div>
                <div class="result-item">
                    <span class="result-label">Order Date</span>
                    <span class="result-value">{{ $order->created_at->format('M d, Y') }}</span>
                </div>
                <div class="result-item">
                    <span class="result-label">Customer Name</span>
                    <span class="result-value">{{ $order->customer->name }}</span>
                </div>
                <div class="result-item">
                    <span class="result-label">Customer Number</span>
                    <span class="result-value">{{ $order->customer->customer_number }}</span>
                </div>
                <div class="result-item">
                    <span class="result-label">Status</span>
                    <span class="status-badge status-{{ strtolower($order->status) }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                
                <!-- Order Photos Section -->
                <div class="order-photos-section" style="margin-top: 1.5rem;">
                    <h3 class="result-subtitle">Order Photos</h3>
                    <div style="display: flex; gap: 1.5rem; flex-wrap: wrap; margin-top: 1rem;">
                        <!-- Processing Photo -->
                        <div class="photo-card" style="flex: 1; min-width: 250px; background: #f8f9fa; border-radius: 10px; padding: 1rem;">
                            <h4 style="margin-bottom: 0.8rem; font-size: 1rem; font-weight: 500; color: var(--secondary-color);">
                                Processing Photo
                            </h4>
                            
                            @if($order->image_path)
                                <img src="@if(strpos($order->image_path, 'mock') !== false) https://placehold.co/600x400/e3f2fd/1976d2?text=Processing+Photo @else {{ asset('storage/' . $order->image_path) }} @endif" 
                                     alt="Order Processing Image" 
                                     style="width:100%; border-radius:8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                            @else
                                <div style="padding: 2rem; background-color: #f1f1f1; border-radius: 8px; border: 1px dashed #d2d2d7; text-align: center;">
                                    <p style="color: var(--secondary-color); font-style: italic;">No processing photo available</p>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Delivery Photo -->
                        <div class="photo-card" style="flex: 1; min-width: 250px; background: #f8f9fa; border-radius: 10px; padding: 1rem;">
                            <h4 style="margin-bottom: 0.8rem; font-size: 1rem; font-weight: 500; color: var(--secondary-color);">
                                Delivery Confirmation
                            </h4>
                            
                            @if($order->photo_delivered)
                                <img src="@if(strpos($order->photo_delivered, 'mock') !== false) https://placehold.co/600x400/e8f5e9/2e7d32?text=Delivery+Photo @else {{ asset('storage/' . $order->photo_delivered) }} @endif" 
                                     alt="Order Delivery Image" 
                                     style="width:100%; border-radius:8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                            @else
                                <div style="padding: 2rem; background-color: #f1f1f1; border-radius: 8px; border: 1px dashed #d2d2d7; text-align: center;">
                                    <p style="color: var(--secondary-color); font-style: italic;">No delivery photo available</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="result-item">
                    <span class="result-label">Delivery Address</span>
                    <span class="result-value">{{ $order->customer->address }}</span>
                </div>
                <hr style="border:none;height:1px;background-color:#f5f5f7;margin:2rem 0;" />
                <h3 class="result-subtitle">Products</h3>
                <table class="product-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th style="text-align:right;">Qty</th>
                            <th style="text-align:right;">Unit Price</th>
                            <th style="text-align:right;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->products as $product)
                        <tr>
                            <td style="text-align:left;">{{ $product->name }}</td>
                            <td>{{ $product->pivot->quantity }}</td>
                            <td>${{ number_format($product->pivot->price,2) }}</td>
                            <td>${{ number_format($product->pivot->quantity * $product->pivot->price,2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" style="text-align:right;font-weight:600;">Total:</td>
                            <td style="font-weight:600;">${{ number_format($order->total_amount,2) }}</td>
                        </tr>
                    </tfoot>
                </table>
                @if(isset($order->notes) && $order->notes)
                <div class="result-item">
                    <span class="result-label">Additional Notes</span>
                    <span class="result-value">{{ $order->notes }}</span>
                </div>
                @endif
            </div>
        @elseif(session('error'))
            <div class="error-message">
                {{ session('error') }}
            </div>
        @endif

        <a href="{{ route('home') }}" class="back-button">← Back to Home</a>
    </div>
</body>
</html>



