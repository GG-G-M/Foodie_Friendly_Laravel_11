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
            <h5 class="fw-bold text-dark mb-0">Order Details - <span class="order-status">{{ ucfirst($order->status) }}</span></h5>
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
                        <p>Status: <span class="badge rounded-pill {{ $order->status === 'pending' ? 'bg-warning' : ($order->status === 'delivering' ? 'bg-primary' : ($order->status === 'delivered' ? 'bg-success' : 'bg-danger')) }} order-status">{{ ucfirst($order->status) }}</span></p>
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
</div>

@section('scripts')
    <script>
        function updateOrderStatus(orderId, cardElement) {
            fetch('{{ url('/order') }}/' + orderId + '/status')
                .then(response => response.json())
                .then(data => {
                    const statusElement = cardElement.querySelector('.order-status');
                    const riderElement = cardElement.querySelector('.rider-info');
                    const currentStatus = statusElement.textContent.toLowerCase();

                    // Update status
                    if (currentStatus !== data.status) {
                        statusElement.textContent = data.status.charAt(0).toUpperCase() + data.status.slice(1);
                        statusElement.classList.remove('bg-warning', 'bg-primary', 'bg-success', 'bg-danger');
                        if (data.status === 'pending') {
                            statusElement.classList.add('bg-warning');
                        } else if (data.status === 'delivering') {
                            statusElement.classList.add('bg-primary');
                        } else if (data.status === 'delivered') {
                            statusElement.classList.add('bg-success');
                            const estDelivery = cardElement.querySelector('.status-timeline p:nth-child(2)');
                            if (estDelivery) estDelivery.style.display = 'none';
                        } else if (data.status === 'cancelled') {
                            statusElement.classList.add('bg-danger');
                            const estDelivery = cardElement.querySelector('.status-timeline p:nth-child(2)');
                            if (estDelivery) estDelivery.style.display = 'none';
                        }
                    }

                    // Update rider info
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
            setInterval(() => updateOrderStatus(orderId, orderCard), 10000);
            updateOrderStatus(orderId, orderCard);
        });
    </script>
@endsection
@endsection