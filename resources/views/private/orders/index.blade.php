<!-- resources/views/private/orders/index.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders Management - Halcon</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <style>
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
            max-width: 1200px;
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

        .orders-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .orders-table th {
            background-color: var(--hover-color);
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: var(--primary-color);
            border-bottom: 1px solid var(--border-color);
        }

        .orders-table td {
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .orders-table tr:last-child td {
            border-bottom: none;
        }

        .orders-table tr:hover {
            background-color: var(--hover-color);
        }

        .view-button, .edit-button, .delete-button {
            display: inline-block;
            padding: 0.5rem 1rem;
            background-color: var(--accent-color);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 0.9rem;
            margin-right: 0.5rem;
            transition: all 0.3s ease;
        }

        .view-button:hover, .edit-button:hover, .delete-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 102, 204, 0.2);
        }

        .edit-button {
            background-color: #ff9800;
        }

        .delete-button {
            background-color: #f44336;
        }

        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.85rem;
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

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: var(--secondary-color);
        }

        .empty-state p {
            font-size: 1.1rem;
            margin-top: 1rem;
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
            <a href="{{ route('private.dashboard') }}" class="back-button">
                ← Back to Dashboard
            </a>
            <h1 class="page-title">Orders Management</h1>
            <p class="page-subtitle">View and manage all orders in the system</p>
        </div>

        @if(count($orders) > 0)
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Invoice Number</th>
                        <th>Customer Name</th>
                        <th>Order Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->invoice_number }}</td>
                            <td>{{ $order->customer_name }}</td>
                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                            <td>
                                <span class="status-badge status-{{ strtolower($order->status) }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('private.orders.show', $order->id) }}" class="view-button">
                                    View Details
                                </a>
                                <a href="{{ route('private.orders.edit', $order->id) }}" class="edit-button">
                                    Edit
                                </a>
                                <form action="{{ route('private.orders.destroy', $order->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-button" onclick="return confirm('Are you sure you want to delete this order?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <p>No orders found in the system.</p>
            </div>
        @endif
    </div>
</body>
</html>

