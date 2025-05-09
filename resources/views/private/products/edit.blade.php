<!-- resources/views/private/products/edit.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - Halcon</title>
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

        .form-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
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
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.1);
        }

        .form-textarea {
            min-height: 100px;
            resize: vertical;
        }

        .error-message {
            color: var(--error-color);
            font-size: 0.875rem;
            margin-top: 0.25rem;
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

            .form-card {
                padding: 1.5rem;
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
                <a href="{{ route('private.products.index') }}" class="nav-link nav-link-active">Products</a>
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
            <a href="{{ route('private.products.index') }}" class="back-button">
                Back to Products
            </a>
            <h1 class="page-title">Edit Product</h1>
            <p class="page-subtitle">Update product information</p>
        </div>

        <div class="form-card">
            <form action="{{ route('private.products.update', $product->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="name" class="form-label">Product Name</label>
                    <input type="text" id="name" name="name" class="form-input" value="{{ old('name', $product->name) }}" required>
                    @error('name')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" name="description" class="form-input form-textarea">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" id="price" name="price" class="form-input" step="0.01" value="{{ old('price', $product->price) }}" required>
                    @error('price')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="stock" class="form-label">Stock</label>
                    <input type="number" id="stock" name="stock" class="form-input" value="{{ old('stock', $product->stock) }}" required>
                    @error('stock')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="button-group">
                    <button type="submit" class="button button-primary">Update Product</button>
                    <a href="{{ route('private.products.index') }}" class="button button-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>