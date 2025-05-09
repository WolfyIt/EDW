<!-- resources/views/private/orders/edit.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order - Halcon</title>
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

        .form-input, .form-select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-input:focus, .form-select:focus {
            outline: none;
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.1);
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

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        .alert-danger {
            background-color: #ffebee;
            color: var(--error-color);
            border: 1px solid #ffcdd2;
        }

        .product-selection-area {
            margin-top: 1.5rem;
            border-top: 1px solid var(--border-color);
            padding-top: 1.5rem;
        }

        .product-adder {
            display: flex;
            gap: 1rem;
            align-items: flex-end;
            margin-bottom: 1rem;
        }

        .product-adder .form-group {
            margin-bottom: 0;
            flex-grow: 1;
        }

        .added-products-list {
            list-style: none;
            padding: 0;
            margin-top: 1rem;
        }

        .added-product-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            margin-bottom: 0.5rem;
            background-color: var(--hover-color);
        }

        .added-product-item span {
            font-size: 0.9rem;
        }

        .remove-product-btn {
            background: none;
            border: none;
            color: var(--error-color);
            cursor: pointer;
            font-size: 1.1rem;
            padding: 0.25rem;
        }

        .order-summary {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 1rem;
            margin-top: 1.5rem;
            border: 1px solid var(--border-color);
        }

        .order-summary h3 {
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .summary-total {
            font-weight: bold;
            margin-top: 0.5rem;
            padding-top: 0.5rem;
            border-top: 1px dashed var(--border-color);
        }

        .image-upload {
            margin-top: 1.5rem;
        }

        .current-image {
            margin-top: 0.5rem;
            max-width: 200px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
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

    <div class="container">
        <div class="page-header">
            <a href="{{ route('private.orders.index') }}" class="back-button">
                Back to Orders
            </a>
            <h1 class="page-title">Edit Order</h1>
            <p class="page-subtitle">Modify order details</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-card">
            <form action="{{ route('private.orders.update', $order->id) }}" method="POST" id="edit-order-form" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="order_number" class="form-label">Order Number</label>
                    <input type="text" id="order_number" name="order_number" class="form-input" value="{{ old('order_number', $order->order_number) }}" readonly>
                </div>

                <div class="form-group">
                    <label for="customer_id" class="form-label">Customer</label>
                    <select id="customer_id" name="customer_id" class="form-select" required>
                        <option value="">Select a customer</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ old('customer_id', $order->customer_id) == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }} ({{ $customer->customer_number ?? 'No customer number' }})
                            </option>
                        @endforeach
                    </select>
                    @error('customer_id')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="form-select" required>
                        @foreach(App\Models\Order::getStatuses() as $status)
                            <option value="{{ $status }}" {{ old('status', $order->status) === $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                    @error('status')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="product-selection-area">
                    <h3 class="form-label">Products</h3>
                    <div class="product-adder">
                        <div class="form-group">
                            <label for="product_select" class="form-label" style="font-size: 0.9em;">Select Product</label>
                            <select id="product_select" class="form-select">
                                <option value="">-- Choose Product --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" data-name="{{ $product->name }}" data-price="{{ $product->price }}" data-stock="{{ $product->stock }}">
                                        {{ $product->name }} (Stock: {{ $product->stock }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="product_quantity" class="form-label" style="font-size: 0.9em;">Quantity</label>
                            <input type="number" id="product_quantity" class="form-input" min="1" value="1">
                        </div>
                        <button type="button" id="add-product-btn" class="button button-secondary" style="padding: 0.6rem 1rem; align-self: flex-end;">Add</button>
                    </div>
                    @error('products')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                    <ul id="added-products-list" class="added-products-list">
                        @foreach($order->products as $orderProduct)
                            <li class="added-product-item" data-product-id="{{ $orderProduct->id }}">
                                <span>{{ $orderProduct->name }} - Qty: {{ $orderProduct->pivot->quantity }}</span>
                                <button type="button" class="remove-product-btn" title="Remove">&times;</button>
                                <input type="hidden" name="products[{{ $loop->index }}][id]" value="{{ $orderProduct->id }}">
                                <input type="hidden" name="products[{{ $loop->index }}][quantity]" value="{{ $orderProduct->pivot->quantity }}">
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div id="order-summary" class="order-summary" style="{{ count($order->products) > 0 ? 'display: block;' : 'display: none;' }}">
                    <h3>Order Summary</h3>
                    <div id="summary-items">
                        @foreach($order->products as $orderProduct)
                            <div class="summary-item">
                                <span>{{ $orderProduct->name }} ({{ $orderProduct->pivot->quantity }} × ${{ number_format($orderProduct->price, 2) }})</span>
                                <span>${{ number_format($orderProduct->price * $orderProduct->pivot->quantity, 2) }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="summary-item summary-total">
                        <span>Total</span>
                        <span id="summary-total-amount">${{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>

                <div class="form-group image-upload">
                    <label for="image" class="form-label">Upload Order Image</label>
                    @if($order->image_path)
                        <div>
                            <p>Current image:</p>
                            <img src="{{ asset('storage/' . $order->image_path) }}" alt="Order Image" class="current-image">
                        </div>
                    @endif
                    <input type="file" id="image" name="image" class="form-input" accept="image/*">
                    @error('image')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="notes" class="form-label">Notes</label>
                    <textarea id="notes" name="notes" class="form-input" rows="3">{{ old('notes', $order->notes) }}</textarea>
                    @error('notes')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="button-group">
                    <button type="submit" class="button button-primary">Update Order</button>
                    <a href="{{ route('private.orders.index') }}" class="button button-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addProductBtn = document.getElementById('add-product-btn');
            const productSelect = document.getElementById('product_select');
            const quantityInput = document.getElementById('product_quantity');
            const addedProductsList = document.getElementById('added-products-list');
            const form = document.getElementById('edit-order-form');
            const orderSummary = document.getElementById('order-summary');
            const summaryItems = document.getElementById('summary-items');
            const summaryTotalAmount = document.getElementById('summary-total-amount');
            
            let productIndex = {{ count($order->products) }};
            let addedProductIds = new Set([{{ $order->products->pluck('id')->implode(',') }}]);
            let totalAmount = {{ $order->total_amount ?? 0 }};

            function updateSummary() {
                summaryItems.innerHTML = '';
                totalAmount = 0;

                // Get all hidden product inputs
                const productInputs = form.querySelectorAll('input[name^="products"][name$="[id]"]');
                
                if (productInputs.length === 0) {
                    orderSummary.style.display = 'none';
                    return;
                }
                
                orderSummary.style.display = 'block';
                
                productInputs.forEach(input => {
                    const productId = input.value;
                    const nameMatch = input.name.match(/products\[(\d+)\]/);
                    
                    if (nameMatch) {
                        const index = nameMatch[1];
                        const quantityInput = form.querySelector(`input[name="products[${index}][quantity]"]`);
                        
                        if (quantityInput) {
                            const quantity = parseInt(quantityInput.value, 10);
                            const productOption = productSelect.querySelector(`option[value="${productId}"]`);
                            
                            if (productOption) {
                                const productName = productOption.getAttribute('data-name');
                                const productPrice = parseFloat(productOption.getAttribute('data-price'));
                                const itemTotal = productPrice * quantity;
                                
                                const summaryItem = document.createElement('div');
                                summaryItem.classList.add('summary-item');
                                summaryItem.innerHTML = `
                                    <span>${productName} (${quantity} × $${productPrice.toFixed(2)})</span>
                                    <span>$${itemTotal.toFixed(2)}</span>
                                `;
                                summaryItems.appendChild(summaryItem);
                                
                                totalAmount += itemTotal;
                            }
                        }
                    }
                });
                
                summaryTotalAmount.textContent = `$${totalAmount.toFixed(2)}`;
                
                // Update hidden total amount field
                let totalAmountInput = form.querySelector('input[name="total_amount"]');
                if (!totalAmountInput) {
                    totalAmountInput = document.createElement('input');
                    totalAmountInput.type = 'hidden';
                    totalAmountInput.name = 'total_amount';
                    form.appendChild(totalAmountInput);
                }
                totalAmountInput.value = totalAmount;
            }

            addProductBtn.addEventListener('click', function() {
                const selectedOption = productSelect.options[productSelect.selectedIndex];
                const productId = selectedOption.value;
                const productName = selectedOption.getAttribute('data-name');
                const productStock = parseInt(selectedOption.getAttribute('data-stock'), 10);
                const productPrice = parseFloat(selectedOption.getAttribute('data-price'));
                const quantity = parseInt(quantityInput.value, 10);

                if (!productId) {
                    alert('Please select a product.');
                    return;
                }
                if (isNaN(quantity) || quantity < 1) {
                    alert('Please enter a valid quantity (minimum 1).');
                    return;
                }
                if (quantity > productStock) {
                    alert(`Quantity (${quantity}) exceeds available stock (${productStock}) for ${productName}.`);
                    return;
                }
                if (addedProductIds.has(parseInt(productId, 10))) {
                    alert(`${productName} has already been added. You can remove it and add it again with a different quantity if needed.`);
                    return;
                }

                const listItem = document.createElement('li');
                listItem.classList.add('added-product-item');
                listItem.setAttribute('data-product-id', productId);
                listItem.innerHTML = `
                    <span>${productName} - Qty: ${quantity}</span>
                    <button type="button" class="remove-product-btn" title="Remove">&times;</button>
                `;
                addedProductsList.appendChild(listItem);

                const idInput = document.createElement('input');
                idInput.type = 'hidden';
                idInput.name = `products[${productIndex}][id]`;
                idInput.value = productId;
                listItem.appendChild(idInput);

                const quantityHiddenInput = document.createElement('input');
                quantityHiddenInput.type = 'hidden';
                quantityHiddenInput.name = `products[${productIndex}][quantity]`;
                quantityHiddenInput.value = quantity;
                listItem.appendChild(quantityHiddenInput);

                addedProductIds.add(parseInt(productId, 10));
                productIndex++;

                productSelect.selectedIndex = 0;
                quantityInput.value = 1;
                
                updateSummary();
            });

            addedProductsList.addEventListener('click', function(e) {
                if (e.target && e.target.classList.contains('remove-product-btn')) {
                    const itemToRemove = e.target.closest('.added-product-item');
                    const productIdToRemove = parseInt(itemToRemove.getAttribute('data-product-id'), 10);
                    
                    itemToRemove.remove();
                    addedProductIds.delete(productIdToRemove);
                    
                    updateSummary();
                }
            });
            
            // Initialize summary on page load
            if (addedProductIds.size > 0) {
                updateSummary();
            }
        });
    </script>
</body>
</html>
