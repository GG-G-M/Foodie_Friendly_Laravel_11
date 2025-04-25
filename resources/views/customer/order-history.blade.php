@extends('layouts.app')

@section('title', 'Order History')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Your Orders</h1>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if ($orders->isEmpty())
        <p>You have no orders.</p>
    @else
        @foreach ($orders as $order)
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header bg-brown text-white py-3">
                    <h4 class="mb-0">
                        Order #{{ $order->id }} - {{ $order->status }}
                        <span class="float-end">Total: ₱{{ number_format($order->total_amount, 2) }}</span>
                    </h4>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Food</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->orderItems as $item)
                                <tr>
                                    <td>{{ $item->food->name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>₱{{ number_format($item->price, 2) }}</td>
                                    <td>₱{{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-between">
                        <span>Subtotal</span>
                        <span>₱{{ number_format($order->orderItems->sum(fn($item) => $item->price * $item->quantity), 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Delivery Fee</span>
                        <span>₱50.00</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Tax (10%)</span>
                        <span>₱{{ number_format($order->orderItems->sum(fn($item) => $item->price * $item->quantity) * 0.1, 2) }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection