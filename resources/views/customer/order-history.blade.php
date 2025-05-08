@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">My Orders</h1>

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

    <!-- Orders List -->
    @forelse($orders as $order)
        <div class="card shadow-sm border-0 mb-4" style="background-color: #fefaf3;">
            <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #c8a879;">
                <h5 class="fw-bold text-dark mb-0">Order Details</h5>
                <span class="text-dark">Placed on {{ $order->order_date->format('Y-m-d H:i') }}</span>
            </div>
            <div class="card-body">
                <h6 class="fw-bold">Items:</h6>
                <ul class="list-group mb-3">
                    @foreach($order->orderItems as $item)
                        <li class="list-group-item d-flex justify-content-between align-items-center" style="background-color: #fffaf2;">
                            <div class="d-flex align-items-center">
                                @if($item->food->image)
                                    <img src="{{ asset('storage/' . $item->food->image) }}" alt="{{ $item->food->name }}" style="width: 50px; height: 50px; object-fit: cover; margin-right: 10px;">
                                @else
                                    <div style="width: 50px; height: 50px; background-color: #ddd; margin-right: 10px;"></div>
                                @endif
                                <span>{{ $item->food->name }} (x{{ $item->quantity }})</span>
                            </div>
                            <span>₱{{ number_format($item->price * $item->quantity, 2) }}</span>
                        </li>
                    @endforeach
                </ul>
                <p><strong>Total Amount:</strong> ₱{{ number_format($order->total_amount, 2) }}</p>
                <p><strong>Delivery Address:</strong> {{ $order->delivery_address }}</p>
                @if ($order->rider)
                    <p><strong>Delivered by:</strong> {{ $order->rider->user->name ?? 'Not assigned' }} @if($order->rider->phone_number) (Phone: {{ $order->rider->phone_number }})@endif</p>
                @endif
                <p><strong>Status:</strong> <span class="order-status-text">{{ ucfirst($order->status) }}</span></p>
                <div class="progress mt-2">
                    <div class="progress-bar" id="status-progress-{{ $order->id }}" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="text-end">
                    <a href="{{ route('order.view', $order->id) }}" class="btn btn-brown">View Order</a>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center">
            <p>No orders found.</p>
            <a href="{{ route('home') }}" class="btn btn-brown">Browse Menu</a>
        </div>
    @endforelse

    {{ $orders->links() }}

    <style>
        .progress {
            height: 20px;
            background-color: #e9ecef;
            border-radius: 10px;
            overflow: hidden;
        }
        .progress-bar {
            transition: width 0.5s ease-in-out;
            border-radius: 10px;
        }
        .progress-bar[aria-valuenow="0"] {
            background-color: #ff9800; /* Orange for Pending */
        }
        .progress-bar[aria-valuenow="50"] {
            background-color: #007bff; /* Blue for Delivering */
        }
        .progress-bar[aria-valuenow="100"] {
            background-color: #28a745; /* Green for Delivered */
        }
        .progress-bar[aria-valuenow="100"][data-status="cancelled"] {
            background-color: #dc3545; /* Red for Cancelled */
        }
    </style>
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

            // Set initial progress for each order
            @foreach($orders as $order)
                const progressElement{{ $order->id }} = document.getElementById('status-progress-{{ $order->id }}');
                let initialProgress{{ $order->id }} = 0;
                if ('{{ $order->status }}' === 'pending') initialProgress{{ $order->id }} = 0;
                else if ('{{ $order->status }}' === 'delivering') initialProgress{{ $order->id }} = 50;
                else if ('{{ $order->status }}' === 'delivered' || '{{ $order->status }}' === 'cancelled') initialProgress{{ $order->id }} = 100;
                progressElement{{ $order->id }}.style.width = initialProgress{{ $order->id }} + '%';
                progressElement{{ $order->id }}.setAttribute('aria-valuenow', initialProgress{{ $order->id }});

                // Set data-status for Cancelled to apply red color
                if ('{{ $order->status }}' === 'cancelled') {
                    progressElement{{ $order->id }}.setAttribute('data-status', 'cancelled');
                }
            @endforeach
        });
    </script>
@endsection
@endsection