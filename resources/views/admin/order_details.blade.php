{{-- @extends('layouts.welcome_admin')

@section('content')
<div class="container py-4">
    <div class="card order-card">
        <div class="card-header order-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Order #{{ $order->id }}</h4>
            <span class="order-badge 
                @if($order->status === 'pending') badge-pending
                @elseif($order->status === 'completed') badge-completed
                @else badge-cancelled @endif">
                {{ ucfirst($order->status) }}
            </span>
        </div>

        <div class="card-body order-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5 class="section-title">Customer Information</h5>
                    <p><strong>Name:</strong> {{ $order->user->name }}</p>
                    <p><strong>Email:</strong> {{ $order->user->email }}</p>
                </div>
                <div class="col-md-6">
                    <h5 class="section-title">Order Summary</h5>
                    <p><strong>Date:</strong> {{ $order->created_at->format('F j, Y H:i') }}</p>
                    <p><strong>Total:</strong> ${{ number_format($order->total_price, 2) }}</p>
                </div>
            </div>

            <h5 class="section-title">Items</h5>
            <div class="table-responsive">
                <table class="table order-table">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Qty</th>
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
            </div>

            <div class="text-end mt-4">
                <a href="{{ route('admin.order_menu') }}" class="btn btn-outline-brown me-2">
                    <i class="bi bi-arrow-left"></i> Back
                </a>

                @if($order->status === 'pending')
                    <form action="{{ route('admin.orders.cancel', $order) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger me-2">
                            <i class="bi bi-x-circle"></i> Cancel
                        </button>
                    </form>
                    <form action="{{ route('admin.orders.complete', $order) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Complete
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    body {
        background-color: #fdfaf7;
        font-family: 'Segoe UI', sans-serif;
    }

    .order-card {
        background: linear-gradient(135deg, #fff8f1, #f9f3ea);
        border: none;
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(92, 64, 51, 0.15);
        overflow: hidden;
    }

    .order-header {
        background-color: #7b4b2d;
        color: #fff;
        padding: 1.25rem 1.5rem;
        border-bottom: none;
    }

    .order-body {
        padding: 1.5rem;
    }

    .section-title {
        font-size: 1.1rem;
        color: #5c3b23;
        margin-bottom: 0.75rem;
    }

    .order-badge {
        padding: 0.4rem 0.8rem;
        border-radius: 12px;
        font-size: 0.85rem;
        text-transform: uppercase;
        font-weight: 500;
    }

    .badge-pending {
        background-color: #e8b04a;
        color: #fff;
    }

    .badge-completed {
        background-color: #5cb85c;
        color: #fff;
    }

    .badge-cancelled {
        background-color: #d9534f;
        color: #fff;
    }

    .order-table th {
        background-color: #f3e5d8;
        color: #5c3b23;
    }

    .order-table td, .order-table th {
        vertical-align: middle;
        text-align: center;
    }

    .btn-outline-brown {
        color: #7b4b2d;
        border-color: #7b4b2d;
    }

    .btn-outline-brown:hover {
        background-color: #7b4b2d;
        color: #fff;
    }

    .btn i {
        margin-right: 4px;
    }
</style>
@endsection --}}
