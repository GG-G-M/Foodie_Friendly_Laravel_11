@extends('layouts.rider')

@section('title', 'Earnings')

@section('content')
<div class="container mt-2 d-flex justify-content-center">

    <div class="col-md-8">
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

        <!-- Earnings -->
        <div class="card shadow" style="border-radius: 12px; background-color: #fefaf3;">
            <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #c8a879;">
                <h5 class="fw-bold text-dark mb-0" style="font-size: 1.5rem;"><i class="bi bi-wallet2 me-1"></i> Earnings</h5>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <h6 class="fw-bold" style="font-size: 1.3rem;">Total Earnings</h6>
                    <p style="font-size: 1.5rem; color: #5D3A00;">₱{{ number_format($totalEarnings, 2) }}</p>
                </div>
                @if($deliveredOrders->isEmpty())
                    <p class="text-center" style="font-size: 1.1rem;">You have not earned anything yet. Start delivering to earn!</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="text-white" style="background-color: #3e3e3e;">
                                <tr>
                                    <th>#</th>
                                    <th>Customer</th>
                                    <th>Delivery Fee</th>
                                    <th>Delivered At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($deliveredOrders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->user->name }}</td>
                                        <td>₱{{ $order->payment_method === 'Cash on Delivery' ? '50.00' : '0.00' }}</td>
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

</div>
@endsection