@extends('layouts.app')

@section('title', 'Cart')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Your Cart</h1>

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($cartItems->isEmpty())
        <div class="text-center">
            <p>Your cart is empty.</p>
            <a href="{{ route('home') }}" class="btn btn-brown">Browse Menu</a>
        </div>
    @else
        <!-- Cart Items -->
        <div class="card shadow-sm border-0 mb-4" style="background-color: #fefaf3;">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mb-0">
                        <thead class="text-white" style="background-color: #3e3e3e;">
                            <tr>
                                <th>Image</th>
                                <th>Item</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cartItems as $item)
                                <tr>
                                    <td>
                                        <img src="{{ asset('storage/' . $item->food->image) }}" alt="{{ $item->food->name }}" style="width: 50px; height: 50px; object-fit: cover;">
                                    </td>
                                    <td>{{ $item->food->name }}</td>
                                    <td>₱{{ number_format($item->food->price, 2) }}</td>
                                    <td>
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <div class="input-group" style="width: 120px;">
                                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="form-control border-brown" style="background-color: #fffaf2;">
                                                <button type="submit" class="btn btn-outline-primary btn-sm"><i class="bi bi-arrow-repeat"></i></button>
                                            </div>
                                        </form>
                                    </td>
                                    <td>₱{{ number_format($item->quantity * $item->food->price, 2) }}</td>
                                    <td>
                                        <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to remove this item?')">
                                                <i class="bi bi-trash"></i> Remove
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-end mt-3">
                    <h5>Total: ₱{{ number_format($total, 2) }}</h5>
                </div>
            </div>
        </div>

        <!-- Checkout Form -->
        <div class="card shadow-sm border-0" style="background-color: #fefaf3;">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Checkout</h5>
                <form action="{{ route('cart.checkout') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Payment Method</label>
                        <select name="payment_method" id="payment_method" class="form-select @error('payment_method') is-invalid @enderror" style="background-color: #fffaf2;" required>
                            <option value="Cash on Delivery">Cash on Delivery</option>
                            <option value="GCash">GCash</option>
                            <option value="PayMaya">PayMaya</option>
                        </select>
                        @error('payment_method')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="delivery_address" class="form-label">Delivery Address</label>
                        <textarea name="delivery_address" id="delivery_address" class="form-control @error('delivery_address') is-invalid @enderror" style="background-color: #fffaf2;" required>{{ old('delivery_address') }}</textarea>
                        @error('delivery_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        @php
                            $deliveryFee = \Illuminate\Support\Facades\DB::table('delivery_fees')
                                ->orderBy('date_added', 'desc')
                                ->first()->fee ?? 50.00;
                        @endphp
                        <div id="delivery-fee-breakdown" style="display: none;">
                            <div class="d-flex justify-content-between">
                                <span>Subtotal</span>
                                <span>₱{{ number_format($total, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Delivery Fee</span>
                                <span>₱{{ number_format($deliveryFee, 2) }}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between fw-bold">
                                <span>Total</span>
                                <span>₱{{ number_format($total + $deliveryFee, 2) }}</span>
                            </div>
                        </div>
                        <div id="no-delivery-fee" style="display: block;">
                            <div class="d-flex justify-content-between fw-bold">
                                <span>Total</span>
                                <span>₱{{ number_format($total, 2) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-brown">
                            <i class="bi bi-checkout me-1"></i> Place Order
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const successAlert = document.getElementById('success-alert');
            if (successAlert) {
                setTimeout(() => {
                    successAlert.classList.remove('show');
                }, 3000);
            }

            const paymentMethod = document.getElementById('payment_method');
            const deliveryFeeBreakdown = document.getElementById('delivery-fee-breakdown');
            const noDeliveryFee = document.getElementById('no-delivery-fee');

            paymentMethod.addEventListener('change', function () {
                if (this.value === 'Cash on Delivery') {
                    deliveryFeeBreakdown.style.display = 'block';
                    noDeliveryFee.style.display = 'none';
                } else {
                    deliveryFeeBreakdown.style.display = 'none';
                    noDeliveryFee.style.display = 'block';
                }
            });

            // Trigger change event on page load to set initial state
            paymentMethod.dispatchEvent(new Event('change'));
        });
    </script>
@endsection
@endsection