@extends('layouts.rider')

@section('title', 'Rider Dashboard')

@section('content')
<div class="container mt-2">
    <h2 class="mb-3 text-center text-brown">🏍️ Rider Dashboard 🏍️</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Current Order -->
    @if($currentOrder)
        <div class="card shadow mb-4" style="border-radius: 12px; background-color: #fefaf3;">
            <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #c8a879;">
                <h5 class="fw-bold text-dark mb-0"><i class="bi bi-receipt me-1"></i> Current Order - #{{ $currentOrder->id }}</h5>
            </div>
            <div class="card-body">
                <p><strong>Customer:</strong> {{ $currentOrder->user->name }}</p>
                <p><strong>Status:</strong> 
                    <span class="badge rounded-pill badge-{{ $currentOrder->status }}">
                        {{ ucfirst($currentOrder->status) }}
                    </span>
                </p>
                <h5>Order Items:</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mb-0">
                        <thead class="text-white" style="background-color: #3e3e3e;">
                            <tr>
                                <th>Food</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($currentOrder->orderItems as $item)
                                <tr>
                                    <td>{{ $item->food->name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>₱{{ number_format($item->price, 2) }}</td>
                                    <td>₱{{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    @php
                        $subtotal = $currentOrder->orderItems->sum(fn($item) => $item->price * $item->quantity);
                        $deliveryFee = 50;
                        $tax = $subtotal * 0.1;
                        $total = $subtotal + $deliveryFee + $tax;
                    @endphp
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
                <div class="mt-3 text-end">
                    @if($currentOrder->status === 'delivering')
                        <form action="{{ route('rider.orders.update_status', $currentOrder) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn text-white" style="background-color: #8b5e3c;">
                                <i class="bi bi-check-circle me-1"></i> Mark as Delivered
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <!-- Available Orders -->
    <div class="card shadow" style="border-radius: 12px; background-color: #fefaf3;">
        <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #c8a879;">
            <h5 class="fw-bold text-dark mb-0"><i class="bi bi-list-ul me-1"></i> Available Orders</h5>
        </div>
        <div class="card-body">
            @if($currentOrder)
                <p class="text-center">You are currently handling an order. Complete it to select another.</p>
            @elseif($pendingOrders->isEmpty())
                <p class="text-center">No pending orders available at the moment.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mb-0">
                        <thead class="text-white" style="background-color: #3e3e3e;">
                            <tr>
                                <th>#</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Ordered At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingOrders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>₱{{ number_format($order->total_amount, 2) }}</td>
                                    <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <form action="{{ route('rider.orders.select', $order) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="bi bi-hand-thumbs-up me-1"></i> Select Order
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .badge-pending {
        background-color: #d2b48c; 
        color: #3e2600;
    }

    .badge-delivering {
        background-color: #ffc107; 
        color: #3e2600;
    }

    .badge-delivered {
        background-color: #28a745; 
        color: #fff;
    }
</style>
@endsection