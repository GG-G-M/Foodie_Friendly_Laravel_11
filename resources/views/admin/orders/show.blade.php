@extends('layouts.welcome_admin')

@section('content')

<!-- Bootstrap Icons CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<div class="container py-4" style="background-color: #f4ece3; border-radius: 15px;">
    <h2 class="mb-4 text-center" style="color: #5D3A00;">
        <i class="bi bi-receipt"></i> Order Details - #{{ $order->id }}
    </h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Customer Information -->
    <div class="card shadow-sm mb-4" style="background-color: #fff7f0;">
        <div class="card-header fw-bold" style="background-color: #d2b48c; color: #3e2600;">
            <i class="bi bi-person"></i> Customer Information
        </div>
        <div class="card-body">
            <p><strong>Name:</strong> {{ $order->user->name }}</p>
            <p><strong>Email:</strong> {{ $order->user->email }}</p>
            <p><strong>Order Date:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
            <p><strong>Status:</strong> 
                <span class="badge 
                    @if($order->status === 'pending') badge-pending
                    @elseif($order->status === 'completed') badge-completed
                    @else badge-cancelled @endif">
                    {{ ucfirst($order->status) }}
                </span>
            </p>
        </div>
    </div>

    <!-- Order Items -->
    <div class="card shadow-sm mb-4" style="background-color: #fff7f0;">
        <div class="card-header fw-bold" style="background-color: #d2b48c; color: #3e2600;">
            <i class="bi bi-cart3"></i> Order Items
        </div>
        <div class="card-body">
            @if($order->orderItems->isEmpty())
                <p>No items found for this order.</p>
            @else
                <table class="table table-bordered table-hover table-light">
                    <thead class="table-dark" style="background-color: #a97c50; color: white;">
                        <tr>
                            <th>Food</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderItems as $item)
                            <tr>
                                <td>{{ $item->food->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>₱{{ number_format($item->price, 2) }}</td>
                                <td>₱{{ number_format($item->price * $item->quantity, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Order Summary -->
                @php
                    $subtotal = $order->orderItems->sum(fn($item) => $item->price * $item->quantity);
                    $deliveryFee = 50;
                    $tax = $subtotal * 0.1; // 10% tax
                    $total = $subtotal + $deliveryFee + $tax;
                @endphp
                <div class="mt-3">
                    <div class="d-flex justify-content-between">
                        <span>Subtotal</span>
                        <span>₱{{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Delivery Fee</span>
                        <span>₱50.00</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Tax (10%)</span>
                        <span>₱{{ number_format($tax, 2) }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold">
                        <span>Total</span>
                        <span style="color: #5D3A00;">₱{{ number_format($total, 2) }}</span>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Back Button -->
    <div class="text-center">
        <a href="{{ route('admin.order_menu') }}" class="btn btn-primary">
            <i class="bi bi-arrow-left"></i> Back to Order List
        </a>
    </div>
</div>

<style>
    .badge-pending {
        background-color: #d2b48c; 
        color: #3e2600;
    }

    .badge-completed {
        background-color: #28a745; 
        color: #fff;
    }

    .badge-cancelled {
        background-color: #dc3545;
        color: #fff;
    }

    body {
        background-color: #eaddcf;
    }
</style>

@endsection