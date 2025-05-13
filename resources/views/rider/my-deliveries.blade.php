@extends('layouts.rider')

@section('title', 'My Deliveries')

@section('content')
<div class="container mt-2 d-flex justify-content-center">

        <!-- Flash Messages -->
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

        <!-- My Deliveries -->
        <div class="card shadow" style="border-radius: 12px; background-color: #fefaf3;">
            <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #c8a879;">
                <h5 class="fw-bold text-dark mb-0" style="font-size: 1.5rem;"><i class="bi bi-truck me-1"></i> My Deliveries</h5>
            </div>
            <div class="card-body">
                @if($deliveredOrders->isEmpty())
                    <p class="text-center" style="font-size: 1.1rem;">You have not completed any deliveries yet.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="text-white" style="background-color: #3e3e3e;">
                                <tr>
                                    <th>#</th>
                                    <th>Customer</th>
                                    <th>Delivery Address</th>
                                    <th>Payment Method</th>
                                    <th>Total Price</th>
                                    <th>Status</th>
                                    <th>Delivered At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($deliveredOrders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->user->name }}</td>
                                        <td>{{ $order->delivery_address ?? 'Not specified' }}</td>
                                        <td>{{ $order->payment_method ?? 'Not specified' }}</td>
                                        <td>
                                            @php
                                                $subtotal = $order->orderItems->sum(fn($item) => $item->price * $item->quantity);
                                                $deliveryFee = $order->delivery_fee ?? 50.00;
                                                $total = $subtotal + $deliveryFee;
                                            @endphp
                                            ₱{{ number_format($total, 2) }}
                                        </td>
                                        <td>
                                            <span class="badge rounded-pill badge-{{ $order->status }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $order->updated_at->format('Y-m-d H:i') }}</td>
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
    .badge-delivered {
        background-color: #28a745; 
        color: #fff;
    }
    .badge-cancelled {
        background-color: #dc3545; 
        color: #fff;
    }
</style>
@endsection