@extends('layouts.welcome_admin')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header fw-bold text-light" style="background-color: #6f4f37;">
            <h4>Create New Order</h4>
        </div>
        
        <div class="card-body" style="background-color: #f5f5f5;">
            <form action="{{ route('admin.orders.store') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="customer_id" class="form-label" style="color: #6f4f37;">Customer</label>
                    <select class="form-select" id="customer_id" name="customer_id" required>
                        <option value="">Select Customer</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->email }})</option>
                        @endforeach
                    </select>
                </div>
                
                <div id="order-items-container">
                    <div class="order-item mb-3 border p-3" style="background-color: #fff8f1; border-radius: 8px;">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label" style="color: #6f4f37;">Food Item</label>
                                <select class="form-select food-select" name="items[0][food_id]" required>
                                    <option value="">Select Food Item</option>
                                    @foreach($foodItems as $food)
                                        <option value="{{ $food->id }}" data-price="{{ $food->price }}">
                                            {{ $food->name }} - ${{ number_format($food->price, 2) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" style="color: #6f4f37;">Quantity</label>
                                <input type="number" class="form-control quantity-input" name="items[0][quantity]" min="1" value="1" required>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="button" class="btn btn-danger remove-item-btn">
                                    <i class="bi bi-trash"></i> Remove
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <button type="button" id="add-item-btn" class="btn btn-success">
                        <i class="bi bi-plus"></i> Add Another Item
                    </button>
                </div>
                
                <div class="text-end">
                    <a href="{{ route('admin.order_menu') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Create Order
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .order-item {
        background-color: #fff8f1;
        border-radius: 8px;
    }
    .card-header {
        background-color: #6f4f37;  /* Brown background for the card header */
        color: white;  /* White text for the header */
    }
    .card-body {
        background-color: #f5f5f5;  /* Light background for the body */
    }
    .form-label {
        color: #6f4f37;  /* Brown color for labels */
    }
    .btn-secondary {
        background-color: #6f4f37;
        border-color: #6f4f37;
    }
    .btn-secondary:hover {
        background-color: #5e3f29;
        border-color: #5e3f29;
    }
    .btn-primary {
        background-color: #9c7c55;
        border-color: #9c7c55;
    }
    .btn-primary:hover {
        background-color: #83653f;
        border-color: #83653f;
    }
    .btn-outline-secondary {
        border-color: #6f4f37;
        color: #6f4f37;
    }
    .btn-outline-secondary:hover {
        background-color: #6f4f37;
        color: white;
    }
    .btn-success {
        background-color: #28a745;  /* Green color for "Add Another Item" button */
        border-color: #28a745;
    }
    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add new item
        document.getElementById('add-item-btn').addEventListener('click', function() {
            const container = document.getElementById('order-items-container');
            const itemCount = container.querySelectorAll('.order-item').length;
            const newItem = container.querySelector('.order-item').cloneNode(true);
            
            // Update the indices in the name attributes
            const inputs = newItem.querySelectorAll('select, input');
            inputs.forEach(input => {
                const name = input.name.replace(/\[\d+\]/, `[${itemCount}]`);
                input.name = name;
                input.value = '';
            });
            
            // Reset values
            newItem.querySelector('.food-select').selectedIndex = 0;
            newItem.querySelector('.quantity-input').value = 1;
            
            container.appendChild(newItem);
        });
        
        // Remove item
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-item-btn')) {
                const items = document.querySelectorAll('.order-item');
                if (items.length > 1) {
                    e.target.closest('.order-item').remove();
                } else {
                    alert('At least one item is required');
                }
            }
        });
    });
</script>
@endsection
    