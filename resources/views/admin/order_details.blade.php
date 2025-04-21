@extends('layouts.welcome_admin')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header fw-bold text-brown">
            <h4>Order #{{ $order->id }} Details</h4>
            <span class="badge 
                @if($order->status === 'pending') badge-pending
                @elseif($order->status === 'completed') badge-completed
                @else badge-cancelled @endif">
                {{ ucfirst($order->status) }}
            </span>
        </div>
        
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>Customer Information</h5>
                    <p><strong>Name:</strong> {{ $order->user->name }}</p>
                    <p><strong>Email:</strong> {{ $order->user->email }}</p>
                </div>
                <div class="col-md-6">
                    <h5>Order Information</h5>
                    <p><strong>Order Date:</strong> {{ $order->created_at->format('F j, Y H:i') }}</p>
                    <p><strong>Total Amount:</strong> ${{ number_format($order->total_price, 2) }}</p>
                </div>
            </div>
            
            <h5>Order Items</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['category'] }}</td>
                            <td>${{ number_format($item['price'], 2) }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            <div class="text-end">
                <a href="{{ route('admin.order_menu') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-left"></i> Back to Orders
                </a>
                
                @if($order->status === 'pending')
                    <form action="{{ route('admin.orders.cancel', $order) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-x-circle"></i> Cancel Order
                        </button>
                    </form>
                    <form action="{{ route('admin.orders.complete', $order) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Mark as Completed
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    /* Use the same styles as order_menu.blade.php */
    body {
        background-color: #f7f3ef;
    }
    .text-brown {
        color: #5e3b27;
    }
    .card {
        border: 1px solid #cbb09c;
        background-color: #fffdf9;
        border-radius: 12px;
    }
    .card-header {
        background-color: #e4c9a4;
        color: #3e2a1c;
    }
    .table thead {
        background-color: #f0e6dd;
    }
    .badge-pending {
        background-color: #ffc107;
        color: #fff;
    }
    .badge-completed {
        background-color: #28a745;
        color: #fff;
    }
    .badge-cancelled {
        background-color: #dc3545;
        color: #fff;
    }
    .btn-primary {
        background-color: #8b5e3c;
        border-color: #8b5e3c;
    }
    .btn-primary:hover {
        background-color: #71452d;
        border-color: #71452d;
    }
    .btn-danger {
        background-color: #c0392b;
        border-color: #c0392b;
    }
    .btn-danger:hover {
        background-color: #a93226;
        border-color: #a93226;
    }
    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
    }
    .btn-success:hover {
        background-color: #218838;
        border-color: #218838;
    }
    .btn i {
        margin-right: 4px;
    }
</style>
@endsection