@extends('layouts.welcome_admin')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header fw-bold text-brown">
            <h4>Create New Order</h4>
        </div>
        
        <div class="card-body">
            <form action="{{ route('admin.orders.store') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="customer_id" class="form-label">Customer</label>
                    <select class="form-select" id="customer_id" name="customer_id" required>
                        <option value="">Select Customer</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->email }})</option>
                        @endforeach
                    </select>
                </div>
                
                <div id="order-items-container">
                    <div class="order-item mb-3 border p-3">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Food Item</label>
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
                                <label class="form-label">Quantity</label>
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
                    <button type="button" id="add-item-btn" class="btn btn-secondary">
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
        background-color: #fffdf9;
        border-radius: 8px;
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