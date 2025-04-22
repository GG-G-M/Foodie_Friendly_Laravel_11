@extends('layouts.app')

@section('title', 'Order Tracker')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow border-0">
                <!-- Card Header -->
                <div class="card-header bg-brown text-white py-3">
                    <h4 class="mb-0">
                        <i class="bi bi-eye-fill me-2"></i>Order Tracking
                        <span class="badge bg-light text-brown float-end">3 Active Orders</span>
                    </h4>
                </div>
                
                <!-- Card Body -->
                <div class="card-body">
                    <!-- Order Tracking Timeline -->
                    <div class="timeline">
                        <!-- Order 1 -->
                        <div class="timeline-item mb-4">
                            <div class="timeline-header d-flex justify-content-between align-items-center mb-2">
                                <h5 class="mb-0 text-brown">Order #FDF-12345</h5>
                                <span class="badge bg-warning text-dark">Preparing</span>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <img src="{{ asset('image/pizza.jpg') }}" class="img-fluid rounded" alt="Pizza">
                                </div>
                                <div class="col-md-6">
                                    <h6>Whole Pizza</h6>
                                    <p class="text-muted mb-1">Quantity: 1</p>
                                    <p class="text-muted mb-1">₱499</p>
                                    <p class="mb-0"><small>Ordered: 15 mins ago</small></p>
                                </div>
                                <div class="col-md-3 text-end">
                                    <button class="btn btn-sm btn-outline-brown">Details</button>
                                </div>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-brown" role="progressbar" style="width: 50%;"></div>
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <small class="text-muted">Order Placed</small>
                                <small class="text-muted">Preparing</small>
                                <small class="text-muted">On the Way</small>
                                <small class="text-muted">Delivered</small>
                            </div>
                        </div>

                        <!-- Order 2 -->
                        <div class="timeline-item mb-4">
                            <div class="timeline-header d-flex justify-content-between align-items-center mb-2">
                                <h5 class="mb-0 text-brown">Order #FDF-12344</h5>
                                <span class="badge bg-success text-white">Delivered</span>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <img src="{{ asset('image/BSK_burger.jpg') }}" class="img-fluid rounded" alt="Burger">
                                </div>
                                <div class="col-md-6">
                                    <h6>BSK Burger</h6>
                                    <p class="text-muted mb-1">Quantity: 2</p>
                                    <p class="text-muted mb-1">₱398</p>
                                    <p class="mb-0"><small>Delivered: 2 hours ago</small></p>
                                </div>
                                <div class="col-md-3 text-end">
                                    <button class="btn btn-sm btn-outline-brown">Reorder</button>
                                </div>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 100%;"></div>
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <small>✓ Order Placed</small>
                                <small>✓ Preparing</small>
                                <small>✓ On the Way</small>
                                <small>✓ Delivered</small>
                            </div>
                        </div>

                        <!-- Order 3 -->
                        <div class="timeline-item">
                            <div class="timeline-header d-flex justify-content-between align-items-center mb-2">
                                <h5 class="mb-0 text-brown">Order #FDF-12343</h5>
                                <span class="badge bg-info text-white">On the Way</span>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <img src="{{ asset('image/fried_chicken.jpg') }}" class="img-fluid rounded" alt="Chicken">
                                </div>
                                <div class="col-md-6">
                                    <h6>Fried Chicken</h6>
                                    <p class="text-muted mb-1">Quantity: 1</p>
                                    <p class="text-muted mb-1">₱299</p>
                                    <p class="mb-0"><small>Estimated delivery: 15 mins</small></p>
                                </div>
                                <div class="col-md-3 text-end">
                                    <button class="btn btn-sm btn-outline-brown">Track</button>
                                </div>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-brown" role="progressbar" style="width: 75%;"></div>
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <small>✓ Order Placed</small>
                                <small>✓ Preparing</small>
                                <small>On the Way</small>
                                <small>Delivered</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom Timeline Styles */
    .timeline {
        position: relative;
        padding-left: 30px;
    }
    .timeline-item {
        position: relative;
        padding-bottom: 20px;
    }
    .timeline-item:before {
        content: '';
        position: absolute;
        left: -20px;
        top: 0;
        width: 2px;
        height: 100%;
        background-color: #D2B48C;
    }
    .timeline-item:last-child:before {
        height: 30px;
    }
    .timeline-header {
        position: relative;
    }
    .timeline-header:before {
        content: '';
        position: absolute;
        left: -30px;
        top: 50%;
        transform: translateY(-50%);
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background-color: #8B4513;
        border: 2px solid #D2B48C;
    }

    /* Consistent Brown Theme */
    .bg-brown { background: linear-gradient(to right, #8B4513, #A67B5B); }
    .text-brown { color: #8B4513; }
    .btn-brown { 
        background-color: #8B4513;
        color: white;
    }
    .btn-brown:hover {
        background-color: #A67B5B;
    }
    .btn-outline-brown {
        border-color: #8B4513;
        color: #8B4513;
    }
    .btn-outline-brown:hover {
        background-color: #F5DEB3;
    }
    .progress-bar.bg-brown {
        background-color: #8B4513 !important;
    }
</style>
@endsection