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

        .back-button::before {
            content: "←";
            margin-right: 0.5rem;
            font-size: 1.2rem;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="search-header">
            <h1 class="search-title">Order Search</h1>
            <p class="search-subtitle">Enter your customer number and invoice number to track your order</p>
        </div>

        <form action="{{ route('order.search') }}" method="GET" class="search-form">
            <div class="form-group">
                <label for="customer_number" class="form-label">Customer Number</label>
                <input type="text" name="customer_number" id="customer_number" class="form-input" required>
            </div>
            <div class="form-group">
                <label for="invoice_number" class="form-label">Invoice Number</label>
                <input type="text" name="invoice_number" id="invoice_number" class="form-input" required>
            </div>
            <button type="submit" class="search-button">Search Order</button>
        </form>

        @if(isset($order))
            <div class="result-section">
                <h2 class="result-title">Order Details</h2>
                <div class="result-item">
                    <span class="result-label">Invoice Number</span>
                    <span class="result-value">{{ $order->invoice_number }}</span>
                </div>
                <div class="result-item">
                    <span class="result-label">Customer Name</span>
                    <span class="result-value">{{ $order->customer_name }}</span>
                </div>
                <div class="result-item">
                    <span class="result-label">Status</span>
                    <span class="result-value">{{ $order->status }}</span>
                </div>
                <div class="result-item">
                    <span class="result-label">Delivery Address</span>
                    <span class="result-value">{{ $order->delivery_address }}</span>
                </div>
            </div>
        @elseif(session('error'))
            <div class="error-message">
                {{ session('error') }}
            </div>
        @endif

        <a href="{{ route('home') }}" class="back-button">Back to Home</a>
    </div>
</body>
</html>



