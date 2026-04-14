<!-- resources/views/private/dashboard.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Halcon</title>
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
            max-width: 1200px;
            margin: 80px auto 0;
            padding: 2rem;
        }

        .page-header {
            margin-bottom: 3rem;
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

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .dashboard-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            text-decoration: none;
            color: var(--primary-color);
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        .card-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .card-description {
            color: var(--secondary-color);
            font-size: 0.9rem;
        }

        .welcome-section {
            background: linear-gradient(135deg, #f5f5f7 0%, #ffffff 100%);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            text-align: center;
        }

        .welcome-title {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--primary-color);
        }

        .welcome-text {
            color: var(--secondary-color);
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
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
            display: none;
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

            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <nav class="nav">
        <a href="{{ route('private.dashboard') }}" class="nav-logo">Halcon</a>
        <div class="nav-links">
            @if(Auth::user()->role && in_array(strtolower(Auth::user()->role->name), ['admin', 'warehouse', 'sales', 'route']))
                <a href="{{ route('private.orders.index') }}" class="nav-link">Orders</a>
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

    <div class="container">
        <div class="page-header">
            <a href="{{ route('home') }}" class="back-button">
                ← Back to Home
            </a>
            <h1 class="page-title">Dashboard</h1>
            <p class="page-subtitle">Welcome to your control center</p>
        </div>

        <div class="welcome-section">
            <h2 class="welcome-title">Welcome to Halcon Admin Dashboard</h2>
            <p class="welcome-text">Manage your orders, users, products, and customers from this central hub. Select an option below to get started.</p>
        </div>

        <div class="dashboard-grid">
            @if(Auth::user()->role && in_array(strtolower(Auth::user()->role->name), ['admin', 'warehouse', 'sales', 'route']))
            <a href="{{ route('private.orders.index') }}" class="dashboard-card">
                <div class="card-icon">📦</div>
                <h3 class="card-title">Orders</h3>
                <p class="card-description">View and manage all orders in the system</p>
            </a>
            @endif

            @if(Auth::user()->role && in_array(strtolower(Auth::user()->role->name), ['admin', 'warehouse', 'purchasing']))
            <a href="{{ route('private.products.index') }}" class="dashboard-card">
                <div class="card-icon">🛍️</div>
                <h3 class="card-title">Products</h3>
                <p class="card-description">Manage your product inventory</p>
            </a>
            @endif

            @if(Auth::user()->role && strtolower(Auth::user()->role->name) === 'admin')
            <a href="{{ route('private.users.index') }}" class="dashboard-card">
                <div class="card-icon">👥</div>
                <h3 class="card-title">Users</h3>
                <p class="card-description">Manage user accounts and permissions</p>
            </a>

            <a href="{{ route('private.customers.index') }}" class="dashboard-card">
                <div class="card-icon">👤</div>
                <h3 class="card-title">Customers</h3>
                <p class="card-description">View and manage customer information</p>
            </a>
            @endif
        </div>
    </div>
</body>
</html>
