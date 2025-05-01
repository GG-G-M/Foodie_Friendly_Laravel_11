@extends('layouts.app')

@section('title', 'Order History')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Order History</h1>

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Orders List -->
    @forelse($orders as $order)
        <div class="card shadow-sm border-0 mb-4" style="background-color: #fefaf3;">
            <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #A67B5B;">
                <h5 class="fw-bold text-white mb-0">Order #{{ $order->id }}</h5>
                <span class="text-white">Placed on {{ $order->order_date->format('Y-m-d H:i') }}</span>
            </div>
            <div class="card-body">
                <h6 class="fw-bold">Items:</h6>
                <ul class="list-group mb-3">
                    @foreach($order->orderItems as $item)
                        <li class="list-group-item d-flex justify-content-between align-items-center" style="background-color: #fffaf2;">
                            <span>{{ $item->food->name }} (x{{ $item->quantity }})</span>
                            <span>₱{{ number_format($item->price * $item->quantity, 2) }}</span>
                        </li>
                    @endforeach
                </ul>
                <p><strong>Total Amount:</strong> ₱{{ number_format($order->total_amount, 2) }}</p>
                <p><strong>Delivery Address:</strong> {{ $order->delivery_address }}</p>
                <p><strong>Status:</strong> <span class="badge rounded-pill {{ $order->status === 'pending' ? 'bg-warning' : ($order->status === 'delivering' ? 'bg-primary' : ($order->status === 'delivered' ? 'bg-success' : 'bg-danger')) }}">{{ ucfirst($order->status) }}</span></p>
            </div>
        </div>
    @empty
        <div class="text-center">
            <p>No orders found.</p>
            <a href="{{ route('home') }}" class="btn btn-brown">Browse Menu</a>
        </div>
    @endforelse

    {{ $orders->links() }}
</div>
@endsection