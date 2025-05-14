@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4 text-dark fw-bold">My Orders</h1>

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
                                    <img src="{{ asset('storage/' . $item->food->image) }}" alt="{{ $item->food->name }}" class="item-image">
                                @else
                                    <div class="placeholder-image"></div>
                                @endif
                                <span class="item-name">{{ $item->food->name }} (x{{ $item->quantity }})</span>
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
                <div class="progress mt-2" role="progressbar" aria-label="Order status progress" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar progress-bar-{{ $order->status }}" id="status-progress-{{ $order->id }}" role="progressbar" style="width: 0%;" aria-valuenow="0"></div>
                </div>
                <div class="text-end mt-3">
                    <a href="{{ route('order.view', $order->id) }}" class="btn btn-custom-brown" aria-label="View order details">View Order</a>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-5">
            <p class="text-muted">No orders found.</p>
            <a href="{{ route('home') }}" class="btn btn-custom-brown" aria-label="Browse menu">Browse Menu</a>
        </div>
    @endforelse

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $orders->links('pagination::bootstrap-4') }}
    </div>
</div>

<style>
    /* Progress Bar (Unchanged) */
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
    .progress-bar[aria-valuenow="0"], .progress-bar-pending {
        background-color: #ff9800; /* Orange for Pending */
    }
    .progress-bar[aria-valuenow="50"], .progress-bar-delivering {
        background-color: #007bff; /* Blue for Delivering */
    }
    .progress-bar[aria-valuenow="100"], .progress-bar-delivered {
        background-color: #28a745; /* Green for Delivered */
    }
    .progress-bar[aria-valuenow="100"][data-status="cancelled"], .progress-bar-cancelled {
        background-color: #dc3545; /* Red for Cancelled */
    }

    /* Custom Button */
    .btn-custom-brown {
        background-color: #8b5e3c;
        color: white;
        border-radius: 5px;
        transition: background-color 0.3s;
    }
    .btn-custom-brown:hover {
        background-color: #6b4a2d;
        color: white;
    }

    /* Item Image */
    .item-image {
        width: 50px;
        height: 50px;
        object-fit: cover;
        margin-right: 10px;
    }
    .placeholder-image {
        width: 50px;
        height: 50px;
        background-color: #ddd;
        margin-right: 10px;
    }

    /* Card Hover */
    .card {
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-3px);
    }

    /* Responsive Adjustments */
    @media (max-width: 576px) {
        .item-image, .placeholder-image {
            width: 40px;
            height: 40px;
        }
        .item-name {
            font-size: 0.9rem;
            max-width: 150px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .card-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
            padding: 0.75rem;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Auto-dismiss alerts
        const successAlert = document.getElementById('success-alert');
        if (successAlert) {
            setTimeout(() => successAlert.classList.remove('show'), 3000);
        }

        // Initialize progress bars
        @foreach($orders as $order)
            const progressElement{{ $order->id }} = document.getElementById('status-progress-{{ $order->id }}');
            if (progressElement{{ $order->id }}) {
                let progressValue = 0;
                if ('{{ $order->status }}' === 'pending') progressValue = 0;
                else if ('{{ $order->status }}' === 'delivering') progressValue = 50;
                else if ('{{ $order->status }}' === 'delivered' || '{{ $order->status }}' === 'cancelled') progressValue = 100;
                progressElement{{ $order->id }}.style.width = progressValue + '%';
                progressElement{{ $order->id }}.setAttribute('aria-valuenow', progressValue);
                if ('{{ $order->status }}' === 'cancelled') {
                    progressElement{{ $order->id }}.setAttribute('data-status', 'cancelled');
                }
                console.log('Order {{ $order->id }}: Status = {{ $order->status }}, Progress = ' + progressValue);
            } else {
                console.error('Progress element for order {{ $order->id }} not found.');
            }
        @endforeach
    });
</script>
@endsection