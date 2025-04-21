@extends('layouts.welcome_admin')

@section('content')

<!-- Bootstrap Icons CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<div class="container py-4">
    <h2 class="mb-4 text-center text-brown">🛒 Order Management</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header fw-bold text-brown">📋 Order List</div>
        <div class="card-body">
            <a href="{{ route('admin.orders.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Create Order
            </a>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Ordered At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>${{ number_format($order->total_price, 2) }}</td>
                            <td>
                                <span class="badge 
                                    @if($order->status === 'pending') badge-pending
                                    @elseif($order->status === 'completed') badge-completed
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
                                    <form action="{{ route('admin.orders.cancel', $order) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-x-circle"></i> Cancel
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.orders.complete', $order) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <i class="bi bi-check-circle"></i> Complete
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            {{ $orders->links() }}
        </div>
    </div>
</div>

<style>
    /* Your existing styles remain the same */
    .badge-success {
        background-color: #28a745;
        color: #fff;
    }
    
    form {
        display: inline-block;
        margin-right: 5px;
    }
    
</style>

@endsection