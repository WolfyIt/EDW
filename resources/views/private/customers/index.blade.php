<!-- resources/views/private/customers/index.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers - Halcon</title>
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
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
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

        .button {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .button-primary {
            background-color: var(--accent-color);
            color: white;
        }

        .button-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .button-primary::before {
            content: "+";
            font-size: 1.2rem;
            font-weight: 300;
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

        .table-container {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        th {
            text-align: left;
            padding: 1rem;
            font-weight: 600;
            color: var(--secondary-color);
            border-bottom: 1px solid var(--border-color);
        }

        td {
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover {
            background-color: var(--hover-color);
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .action-button {
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .view-button {
            color: var(--accent-color);
            background-color: rgba(0, 102, 204, 0.1);
        }

        .edit-button {
            color: var(--success-color);
            background-color: rgba(52, 199, 89, 0.1);
        }

        .delete-button {
            color: var(--error-color);
            background-color: rgba(255, 59, 48, 0.1);
            border: none;
            cursor: pointer;
        }

        .action-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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

            .table-container {
                padding: 1rem;
            }

            .page-header {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    <nav class="nav">
        <a href="{{ route('private.dashboard') }}" class="nav-logo">Halcon</a>
        <div class="nav-links">
            @if(Auth::user()->role && in_array(strtolower(Auth::user()->role->name), ['admin', 'warehouse', 'sales', 'purchasing', 'route']))
                <a href="{{ route('private.orders.index') }}" class="nav-link">Orders</a>
            @endif
            @if(Auth::user()->role && in_array(strtolower(Auth::user()->role->name), ['admin', 'warehouse', 'purchasing']))
                <a href="{{ route('private.products.index') }}" class="nav-link">Products</a>
            @endif
            @if(Auth::user()->role && strtolower(Auth::user()->role->name) === 'admin')
                <a href="{{ route('private.users.index') }}" class="nav-link">Users</a>
                <a href="{{ route('private.customers.index') }}" class="nav-link nav-link-active">Customers</a>
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
            <div>
                <a href="{{ route('private.dashboard') }}" class="back-button">
                    Back to Dashboard
                </a>
                <h1 class="page-title">Customers</h1>
                <p class="page-subtitle">Manage your customer database</p>
            </div>
            <a href="{{ route('private.customers.create') }}" class="button button-primary">New Customer</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customers as $customer)
                        <tr>
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->phone }}</td>
                            <td>{{ $customer->address }}</td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('private.customers.show', $customer) }}" class="action-button view-button">View</a>
                                    <a href="{{ route('private.customers.edit', $customer) }}" class="action-button edit-button">Edit</a>
                                    <form action="{{ route('private.customers.destroy', $customer) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-button delete-button" onclick="return confirm('Are you sure you want to delete this customer?')">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>