@extends('layouts.app')

@section('content')
<div class="container py-4" style="background-color: #f4ece3; border-radius: 15px;">
    <h2 class="mb-4 text-center" style="color: #5D3A00;">📍 Order Tracker</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($orders->isEmpty())
        <p class="text-center">You have no orders to track.</p>
    @else
        @foreach($orders as $order)
            <div class="card shadow-sm mb-3" style="background-color: #fff7f0;">
                <div class="card-header" style="background-color: #d2b48c; color: #3e2600;">
                    Order #{{ $order->id }} - {{ $order->created_at->format('Y-m-d H:i') }}
                </div>
                <div class="card-body">
                    <h5>Status: 
                        <span class="badge 
                            @if($order->status === 'pending') badge-pending
                            @elseif($order->status === 'delivering') badge-delivering
                            @elseif($order->status === 'delivered') badge-delivered
                            @else badge-cancelled @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </h5>
                    <h6>Items:</h6>
                    <ul>
                        @foreach($order->orderItems as $item)
                            <li>{{ $item->food->name }} (x{{ $item->quantity }}) - ₱{{ number_format($item->price * $item->quantity, 2) }}</li>
                        @endforeach
                    </ul>
                    <p><strong>Total:</strong> ₱{{ number_format($order->total_amount, 2) }}</p>
                    @if($order->rider)
                        <p><strong>Rider:</strong> {{ $order->rider->name }}</p>
                    @else
                        <p><strong>Rider:</strong> Not assigned yet.</p>
                    @endif
                </div>
            </div>
        @endforeach

        <div class="mt-3">
            {{ $orders->links() }}
        </div>
    @endif
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

    .badge-cancelled {
        background-color: #dc3545;
        color: #fff;
    }

    body {
        background-color: #eaddcf;
    }
</style>
@endsection