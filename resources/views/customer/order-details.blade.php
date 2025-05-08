@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Order #{{ $order->id }}</h1>

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

    <div class="card shadow-sm border-0 mb-4" style="background-color: #fefaf3;">
        <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #c8a879;">
            <h5 class="fw-bold text-dark mb-0">Order Details - <span class="order-status-text">{{ ucfirst($order->status) }}</span></h5>
            <span class="text-dark">Placed on {{ $order->order_date->format('Y-m-d H:i') }}</span>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
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
                    <p><strong>Payment Method:</strong> {{ $order->payment_method }}</p>
                    <p><strong>Payment Status:</strong> {{ ucfirst($order->payment_status) }}</p>
                    <p><strong>Delivery Address:</strong> {{ $order->delivery_address }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold">Tracking Information:</h6>
                    <div class="status-timeline">
                        <p>Status: <span class="order-status-text">{{ ucfirst($order->status) }}</span></p>
                        <div class="progress mt-2">
                            <div class="progress-bar" id="status-progress" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        @if($order->status !== 'delivered' && $order->status !== 'cancelled')
                            <p>Estimated Delivery: {{ $order->order_date->addMinutes(30)->format('Y-m-d H:i') }} (approx. 30 mins)</p>
                        @endif
                        @if($order->rider)
                            <p class="rider-info">Rider: {{ $order->rider->user->name ?? 'Not assigned' }} (Phone: {{ $order->rider->phone_number ?? 'N/A' }})</p>
                        @else
                            <p class="rider-info">Rider: Not assigned yet</p>
                        @endif
                    </div>
                    @if($order->status === 'pending')
                        <div class="mt-3">
                            <form action="{{ route('order.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this order?');">
                                @csrf
                                <button type="submit" class="btn btn-danger">Cancel Order</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
            <div class="text-end mt-3">
                <a href="{{ route('order-history') }}" class="btn btn-brown">Back to My Orders</a>
            </div>
        </div>
    </div>

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
        function updateOrderStatus(orderId, cardElement) {
            fetch('{{ url('/order') }}/' + orderId + '/status')
                .then(response => response.json())
                .then(data => {
                    const statusTextElement = cardElement.querySelector('.order-status-text');
                    const progressElement = cardElement.querySelector('#status-progress');
                    const currentStatus = statusTextElement.textContent.toLowerCase();

                    // Update status text
                    if (currentStatus !== data.status) {
                        statusTextElement.textContent = data.status.charAt(0).toUpperCase() + data.status.slice(1);
                    }

                    // Update progress bar
                    let progress = 0;
                    if (data.status === 'pending') progress = 0;
                    else if (data.status === 'delivering') progress = 50;
                    else if (data.status === 'delivered' || data.status === 'cancelled') progress = 100;

                    progressElement.style.width = progress + '%';
                    progressElement.setAttribute('aria-valuenow', progress);

                    // Set data-status for Cancelled to apply red color
                    if (data.status === 'cancelled') {
                        progressElement.setAttribute('data-status', 'cancelled');
                    } else {
                        progressElement.removeAttribute('data-status');
                    }

                    // Update rider info
                    const riderElement = cardElement.querySelector('.rider-info');
                    if (data.rider && riderElement) {
                        riderElement.textContent = `Rider: ${data.rider.name} (Phone: ${data.rider.phone})`;
                    }
                })
                .catch(error => console.error('Error fetching order status:', error));
        }

        document.addEventListener('DOMContentLoaded', function () {
            const successAlert = document.getElementById('success-alert');
            if (successAlert) {
                setTimeout(() => {
                    successAlert.classList.remove('show');
                }, 3000);
            }

            const orderCard = document.querySelector('.card');
            const orderId = {{ $order->id }};
            const progressElement = orderCard.querySelector('#status-progress');

            // Set initial progress based on current status
            let initialProgress = 0;
            if ('{{ $order->status }}' === 'pending') initialProgress = 0;
            else if ('{{ $order->status }}' === 'delivering') initialProgress = 50;
            else if ('{{ $order->status }}' === 'delivered' || '{{ $order->status }}' === 'cancelled') initialProgress = 100;
            progressElement.style.width = initialProgress + '%';
            progressElement.setAttribute('aria-valuenow', initialProgress);

            // Set initial data-status for Cancelled
            if ('{{ $order->status }}' === 'cancelled') {
                progressElement.setAttribute('data-status', 'cancelled');
            }

            setInterval(() => updateOrderStatus(orderId, orderCard), 10000);
            updateOrderStatus(orderId, orderCard);
        });
    </script>
@endsection
@endsection