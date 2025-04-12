@extends('layouts.app')

@section('title', 'My Cart')

@section('content')
<div class="container mt-4">
    <div class="row">
        <!-- Cart Items Column -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-brown text-white py-3">
                    <h4 class="mb-0">
                        <i class="bi bi-cart3 me-2"></i>My Shopping Cart
                        <span class="badge bg-light text-brown float-end">3 items</span>
                    </h4>
                </div>
                
                <div class="card-body">
                    <!-- Cart Item 1 -->
                    <div class="row align-items-center mb-3 pb-3 border-bottom">
                        <div class="col-md-2">
                            <img src="{{ asset('image/pizza.jpg') }}" class="img-fluid rounded" alt="Pizza">
                        </div>
                        <div class="col-md-4">
                            <h5 class="mb-1">Whole Pizza</h5>
                            <p class="text-muted mb-0">Delicious 12" pizza</p>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <button class="btn btn-outline-brown" type="button">-</button>
                                <input type="text" class="form-control text-center border-brown" value="1">
                                <button class="btn btn-outline-brown" type="button">+</button>
                            </div>
                        </div>
                        <div class="col-md-2 text-end">
                            <h5 class="mb-0">₱499</h5>
                        </div>
                        <div class="col-md-1 text-end">
                            <button class="btn btn-link text-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Cart Item 2 -->
                    <div class="row align-items-center mb-3 pb-3 border-bottom">
                        <div class="col-md-2">
                            <img src="{{ asset('image/BSK_burger.jpg') }}" class="img-fluid rounded" alt="Burger">
                        </div>
                        <div class="col-md-4">
                            <h5 class="mb-1">BSK Burger</h5>
                            <p class="text-muted mb-0">Juicy beef burger</p>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <button class="btn btn-outline-brown" type="button">-</button>
                                <input type="text" class="form-control text-center border-brown" value="2">
                                <button class="btn btn-outline-brown" type="button">+</button>
                            </div>
                        </div>
                        <div class="col-md-2 text-end">
                            <h5 class="mb-0">₱398</h5>
                        </div>
                        <div class="col-md-1 text-end">
                            <button class="btn btn-link text-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Continue Shopping Button -->
                    <div class="mt-4">
                        <a href="{{ route('home') }}" class="btn btn-outline-brown">
                            <i class="bi bi-arrow-left me-2"></i>Continue Shopping
                        </a>
                    </div>
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
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal (3 items)</span>
                        <span>₱897</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Delivery Fee</span>
                        <span>₱50</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Tax</span>
                        <span>₱89.70</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold mb-4">
                        <span>Total</span>
                        <span class="text-brown">₱1,036.70</span>
                    </div>
                    <button class="btn btn-brown w-100 py-2">
                        <i class="bi bi-lock-fill me-2"></i>Proceed to Checkout
                    </button>
                    
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