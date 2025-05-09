<!-- resources/views/private/users/show.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details - Halcon</title>
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

        .user-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .user-info {
            display: grid;
            grid-template-columns: 150px 1fr;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .info-label {
            color: var(--secondary-color);
            font-weight: 500;
        }

        .info-value {
            color: var(--primary-color);
            font-weight: 400;
        }

        .actions {
            margin-top: 2rem;
            display: flex;
            gap: 1rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .btn-primary {
            background-color: var(--accent-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: #0055b3;
        }

        .btn-secondary {
            background-color: var(--hover-color);
            color: var(--primary-color);
        }

        .btn-secondary:hover {
            background-color: #e5e5e7;
        }
    </style>
</head>
<body>
    <nav class="nav">
        <a href="{{ route('private.dashboard') }}" class="nav-logo">Halcon</a>
        <div class="nav-links">
            @if(Auth::user()->role && in_array(strtolower(Auth::user()->role->name), ['admin', 'warehouse', 'sales', 'purchasing']))
                <a href="{{ route('private.orders.index') }}" class="nav-link">Orders</a>
            @endif
            @if(Auth::user()->role && in_array(strtolower(Auth::user()->role->name), ['admin', 'warehouse']))
                <a href="{{ route('private.products.index') }}" class="nav-link">Products</a>
            @endif
            @if(Auth::user()->role && strtolower(Auth::user()->role->name) === 'admin')
                <a href="{{ route('private.users.index') }}" class="nav-link nav-link-active">Users</a>
                <a href="{{ route('private.customers.index') }}" class="nav-link">Customers</a>
            @endif
            {{-- Logout Link --}}
            @auth
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
            @endauth
        </div>
    </nav>

    <div class="container">
        <div class="page-header">
            <h1 class="page-title">User Details</h1>
            <p class="page-subtitle">View detailed information about {{ $user->name }}</p>
        </div>

        <div class="user-card">
            <div class="user-info">
                <div class="info-label">Name</div>
                <div class="info-value">{{ $user->name }}</div>

                <div class="info-label">Email</div>
                <div class="info-value">{{ $user->email }}</div>

                <div class="info-label">Role</div>
                <div class="info-value">{{ $user->role->name }}</div>

                <div class="info-label">Created At</div>
                <div class="info-value">{{ $user->created_at->format('F j, Y') }}</div>

                <div class="info-label">Updated At</div>
                <div class="info-value">{{ $user->updated_at->format('F j, Y') }}</div>
            </div>

            <div class="actions">
                <a href="{{ route('private.users.edit', $user) }}" class="btn btn-primary">Edit User</a>
                <a href="{{ route('private.users.index') }}" class="btn btn-secondary">Back to Users</a>
            </div>
        </div>
    </div>
</body>
</html>
