@extends('layouts.app')

@section('title', 'My Cart')

@section('content')
<div class="container mt-4">
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <div class="row">
        <!-- Cart Items Column -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-brown text-white py-3">
                    <h4 class="mb-0">
                        <i class="bi bi-cart3 me-2"></i>My Shopping Cart
                        <span class="badge bg-light text-brown float-end">{{ $cartItems->count() }} items</span>
                    </h4>
                </div>
                
                <div class="card-body">
                    @if ($cartItems->isEmpty())
                        <p>Your cart is empty.</p>
                    @else
                        @foreach ($cartItems as $item)
                            <div class="row align-items-center mb-3 pb-3 border-bottom">
                                <div class="col-md-2">
                                    <img src="{{ asset('storage/' . $item->food->image) }}" class="img-fluid rounded" alt="{{ $item->food->name }}">
                                </div>
                                <div class="col-md-4">
                                    <h5 class="mb-1">{{ $item->food->name }}</h5>
                                    <p class="text-muted mb-0">{{ $item->food->description }}</p>
                                </div>
                                <div class="col-md-3">
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <div class="input-group">
                                            <button class="btn btn-outline-brown" type="button" onclick="this.nextElementSibling.stepDown()">-</button>
                                            <input type="number" name="quantity" class="form-control text-center border-brown" value="{{ $item->quantity }}" min="1">
                                            <button class="btn btn-outline-brown" type="button" onclick="this.previousElementSibling.stepUp()">+</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-2 text-end">
                                    <h5 class="mb-0">₱{{ number_format($item->food->price * $item->quantity, 2) }}</h5>
                                </div>
                                <div class="col-md-1 text-end">
                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-link text-danger" type="submit">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                        <!-- Continue Shopping Button -->
                        <div class="mt-4">
                            <a href="{{ route('home') }}" class="btn btn-outline-brown">
                                <i class="bi bi-arrow-left me-2"></i>Continue Shopping
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Order Summary Column -->
        <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-brown text-white py-3">
                    <h4 class="mb-0"><i class="bi bi-receipt me-2"></i>Order Summary</h4>
                </div>
                <div class="card-body">
                    @php
                        $subtotal = $cartItems->sum(fn($item) => $item->food->price * $item->quantity);
                        $deliveryFee = 50;
                        $tax = $subtotal * 0.1; // 10% tax
                        $total = $subtotal + $deliveryFee + $tax;
                    @endphp
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal ({{ $cartItems->count() }} items)</span>
                        <span>₱{{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Delivery Fee</span>
                        <span>₱{{ number_format($deliveryFee, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Tax</span>
                        <span>₱{{ number_format($tax, 2) }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold mb-4">
                        <span>Total</span>
                        <span class="text-brown">₱{{ number_format($total, 2) }}</span>
                    </div>
                    <a href="{{ route('checkout') }}" class="btn btn-brown w-100 py-2 {{ $cartItems->isEmpty() ? 'disabled' : '' }}">
                        <i class="bi bi-lock-fill me-2"></i>Proceed to Checkout
                    </a>
                    
                    <!-- Payment Methods -->
                    <div class="mt-4 pt-2 border-top">
                        <p class="small text-muted mb-2">We accept:</p>
                        <div class="d-flex gap-2">
                            <img src="https://cdn-icons-png.flaticon.com/512/196/196578.png" width="40" alt="Visa">
                            <img src="https://cdn-icons-png.flaticon.com/512/196/196561.png" width="40" alt="PayPal">
                            <img src="https://cdn-icons-png.flaticon.com/512/196/196566.png" width="40" alt="Mastercard">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Ensure consistent brown theme */
    .bg-brown { background: linear-gradient(to right, #8B4513, #A67B5B); }
    .border-brown { border-color: #A67B5B !important; }
    .text-brown { color: #8B4513; }
    .btn-brown { 
        background-color: #A67B5B;
        border-color: #8B4513;
        color: white;
    }
    .btn-brown:hover {
        background-color: #8B4513;
        color: white;
    }
    .btn-outline-brown {
        border-color: #A67B5B;
        color: #5A3E36;
    }
    .btn-outline-brown:hover {
        background-color: #F5DEB3;
    }
</style>
@endsection