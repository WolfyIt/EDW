<!-- resources/views/private/customers/show.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Details - Halcon</title>
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

        .profile-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .profile-section {
            margin-bottom: 2rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid var(--border-color);
        }

        .profile-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--primary-color);
        }

        .info-group {
            margin-bottom: 1rem;
        }

        .info-label {
            font-size: 0.875rem;
            color: var(--secondary-color);
            margin-bottom: 0.25rem;
        }

        .info-value {
            font-size: 1rem;
            color: var(--primary-color);
            font-weight: 500;
        }

        .button-group {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .button {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
        }

        .button-primary {
            background-color: var(--accent-color);
            color: white;
        }

        .button-secondary {
            background-color: #f8f9fa;
            color: var(--primary-color);
            border: 1px solid var(--border-color);
        }

        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        .alert-success {
            background-color: #e8f5e9;
            color: var(--success-color);
            border: 1px solid #c8e6c9;
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

            .profile-card {
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
            <a href="{{ route('private.products.index') }}" class="nav-link">Products</a>
            <a href="{{ route('private.users.index') }}" class="nav-link">Users</a>
            <a href="{{ route('private.customers.index') }}" class="nav-link">Customers</a>
        </div>
    </nav>

    <div class="container">
        <div class="page-header">
            <a href="{{ route('private.customers.index') }}" class="back-button">← Back to Customers</a>
            <h1 class="page-title">Customer Details</h1>
            <p class="page-subtitle">View and manage customer information</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="profile-card">
            <div class="profile-section">
                <h2 class="section-title">Basic Information</h2>
                <div class="info-group">
                    <div class="info-label">Name</div>
                    <div class="info-value">{{ $customer->name }}</div>
                </div>
                <div class="info-group">
                    <div class="info-label">Email</div>
                    <div class="info-value">{{ $customer->email }}</div>
                </div>
            </div>

            <div class="profile-section">
                <h2 class="section-title">Contact Information</h2>
                <div class="info-group">
                    <div class="info-label">Phone</div>
                    <div class="info-value">{{ $customer->phone }}</div>
                </div>
                <div class="info-group">
                    <div class="info-label">Address</div>
                    <div class="info-value">{{ $customer->address }}</div>
                </div>
            </div>

            <div class="button-group">
                <a href="{{ route('private.customers.edit', $customer->id) }}" class="button button-primary">Edit Customer</a>
                <a href="{{ route('private.customers.index') }}" class="button button-secondary">Back to Customers</a>
            </div>
        </div>
    </div>
</body>
</html>