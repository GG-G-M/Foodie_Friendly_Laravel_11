@extends('layouts.welcome_admin')

@section('content')

<!-- Bootstrap Icons CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<div class="container py-4" style="background-color: #f4ece3; border-radius: 15px;">
    <h2 class="mb-4 text-center" style="color: #5D3A00;">
        <i class="bi bi-plus-circle"></i> Create New Order
    </h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm" style="background-color: #fff7f0;">
        <div class="card-header fw-bold" style="background-color: #d2b48c; color: #3e2600;">
            <i class="bi bi-cart3"></i> Order Details
        </div>
        <div class="card-body">
            <form action="{{ route('admin.orders.store') }}" method="POST">
                @csrf

                <!-- Customer Selection -->
                <div class="mb-3">
                    <label for="customer_id" class="form-label" style="color: #6F4F37;">Customer</label>
                    <select class="form-select" id="customer_id" name="customer_id" required>
                        <option value="">Select Customer</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Order Items -->
                <div id="order-items-container">
                    <div class="order-item mb-3 border p-3" style="background-color: #fff; border-radius: 10px;">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label" style="color: #6F4F37;">Food Item</label>
                                <select class="form-select food-item" name="items[0][food_id]" required>
                                    <option value="">Select Food</option>
                                    @foreach($foods as $food)
                                        <option value="{{ $food->id }}" data-price="{{ $food->price }}">{{ $food->name }} (₱{{ number_format($food->price, 2) }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label" style="color: #6F4F37;">Quantity</label>
                                <input type="number" class="form-control quantity" name="items[0][quantity]" min="1" value="1" required>
                            </div>
                            <div class="col-md-3 text-end">
                                <button type="button" class="btn btn-danger remove-item mt-4">
                                    <i class="bi bi-trash"></i> Remove
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add More Items Button -->
                <div class="mb-3">
                    <button type="button" id="add-item" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Add Another Item
                    </button>
                </div>

                <!-- Order Summary -->
                <div class="card shadow-sm mb-3" style="background-color: #fff;">
                    <div class="card-header fw-bold" style="background-color: #d2b48c; color: #3e2600;">
                        <i class="bi bi-receipt"></i> Order Summary
                    </div>
                    <div class="card-body">
                        @php
                            $deliveryFee = 50;
                            $taxRate = 0.1; // 10% tax
                        @endphp
                        <div class="d-flex justify-content-between">
                            <span>Subtotal</span>
                            <span id="subtotal">₱0.00</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Delivery Fee</span>
                            <span>₱{{ number_format($deliveryFee, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Tax (10%)</span>
                            <span id="tax">₱0.00</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold">
                            <span>Total</span>
                            <span id="total" style="color: #5D3A00;">₱0.00</span>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle"></i> Create Order
                    </button>
                    <a href="{{ route('admin.order_menu') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    body {
        background-color: #eaddcf;
    }
</style>

<script>
    let itemIndex = 1;

    // Add new order item
    document.getElementById('add-item').addEventListener('click', function() {
        const container = document.getElementById('order-items-container');
        const newItem = document.createElement('div');
        newItem.className = 'order-item mb-3 border p-3';
        newItem.style.backgroundColor = '#fff';
        newItem.style.borderRadius = '10px';
        newItem.innerHTML = `
            <div class="row">
                <div class="col-md-6">
                    <label class="form-label" style="color: #6F4F37;">Food Item</label>
                    <select class="form-select food-item" name="items[${itemIndex}][food_id]" required>
                        <option value="">Select Food</option>
                        @foreach($foods as $food)
                            <option value="{{ $food->id }}" data-price="{{ $food->price }}">{{ $food->name }} (₱{{ number_format($food->price, 2) }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label" style="color: #6F4F37;">Quantity</label>
                    <input type="number" class="form-control quantity" name="items[${itemIndex}][quantity]" min="1" value="1" required>
                </div>
                <div class="col-md-3 text-end">
                    <button type="button" class="btn btn-danger remove-item mt-4">
                        <i class="bi bi-trash"></i> Remove
                    </button>
                </div>
            </div>
        `;
        container.appendChild(newItem);
        itemIndex++;
        updateTotal();
    });

    // Remove order item
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-item') || e.target.parentElement.classList.contains('remove-item')) {
            e.target.closest('.order-item').remove();
            updateTotal();
        }
    });

    // Update total when quantity or food item changes
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('quantity') || e.target.classList.contains('food-item')) {
            updateTotal();
        }
    });

    function updateTotal() {
        let subtotal = 0;
        const deliveryFee = 50;
        const taxRate = 0.1;

        document.querySelectorAll('.order-item').forEach(item => {
            const foodSelect = item.querySelector('.food-item');
            const quantityInput = item.querySelector('.quantity');
            if (foodSelect && quantityInput) {
                const price = parseFloat(foodSelect.options[foodSelect.selectedIndex]?.dataset.price || 0);
                const quantity = parseInt(quantityInput.value || 0);
                subtotal += price * quantity;
            }
        });

        const tax = subtotal * taxRate;
        const total = subtotal + deliveryFee + tax;

        document.getElementById('subtotal').textContent = '₱' + subtotal.toFixed(2);
        document.getElementById('tax').textContent = '₱' + tax.toFixed(2);
        document.getElementById('total').textContent = '₱' + total.toFixed(2);
    }

    // Initial total calculation
    updateTotal();
</script>

@endsection