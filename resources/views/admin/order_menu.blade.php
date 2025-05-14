@extends('layouts.welcome_admin')

@section('content')

<!-- Bootstrap Icons CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<div class="container py-4" style="background-color: #f4ece3; border-radius: 15px;">
    <h2 class="mb-4 text-center" style="color: #5D3A00;">🛒 Order Management</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        @endif

    <div class="card shadow-sm" style="background-color: #fff7f0;">
        <div class="card-header fw-bold" style="background-color: #d2b48c; color: #3e2600;">
            📋 Order List
        </div>
        <div class="card-body">
            {{-- <a href="{{ route('admin.orders.create') }}" class="btn btn-success mb-3 me-2">
                <i class="bi bi-plus-circle"></i> Create Order
            </a> --}}
            <a href="{{ route('admin.set_delivery_fee') }}" class="btn btn-info mb-3">
                <i class="bi bi-gear"></i> Set Delivery Fee
            </a>
            @if($orders->isEmpty())
                <p class="text-center">No orders available.</p>
            @else
                <table class="table table-bordered table-hover table-light">
                    <thead class="table-dark" style="background-color: #a97c50; color: white;">
                        <tr>
                            <th>#</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Delivery Fee</th>
                            <th>Status</th>
                            <th>Ordered At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            @php
                                $totalAmount = $order->total_amount + ($order->delivery_fee ?? 0.00);
                            @endphp
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->user->name }}</td>
                                <td>
                                    ₱{{ number_format($totalAmount, 2) }}
                                    @if($order->payment_method === 'GCash' || $order->payment_method === 'PayMaya' || ($order->payment_method === 'Cash on Delivery' && $order->status === 'delivered'))
                                        <span class="badge badge-paid" style="background-color: #28a745; color: #fff; margin-left: 5px;">Paid</span>
                                    @endif
                                </td>
                                <td>₱{{ number_format($order->delivery_fee ?? 0.00, 2) }}</td>
                                <td>
                                    <span class="badge 
                                        @if($order->status === 'pending') badge-pending
                                        @elseif($order->status === 'delivering') badge-delivering
                                        @elseif($order->status === 'delivered') badge-delivered
                                        @else badge-cancelled @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                    
                                    @if($order->status === 'pending')
                                        <form action="{{ route('admin.orders.start_delivery', $order) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-warning">
                                                <i class="bi bi-truck"></i> Start Delivery
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.orders.cancel', $order) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-x-circle"></i> Cancel
                                            </button>
                                        </form>
                                    @elseif($order->status === 'delivering')
                                        <form action="{{ route('admin.orders.complete_delivery', $order) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">
                                                <i class="bi bi-check-circle"></i> Complete Delivery
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                            <div class="d-flex justify-content-center mt-4">
                {{ $orders->appends([
                    'search' => request('search'),
                    'role_filter' => request('role_filter')
                ])->links('pagination::bootstrap-4') }}
                </div>
{{-- 
                <div class="mt-3">
                    {{ $orders->links() }}
                </div> --}}

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

    .badge-cancelled {
        background-color: #dc3545;
        color: #fff;
    }

    .badge-paid {
        background-color: #28a745;
        color: #fff;
        padding: 4px 8px;
        border-radius: 5px;
    }

    form {
        display: inline-block;
        margin-right: 5px;
    }

    body {
        background-color: #eaddcf;
    }
</style>

@endsection