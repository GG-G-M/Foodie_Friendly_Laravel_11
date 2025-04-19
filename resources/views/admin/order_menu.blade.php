@extends('layouts.welcome_admin')

@section('content')

<!-- Bootstrap Icons CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
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

    .btn i {
        margin-right: 4px;
    }

    .table td,
    .table th {
        vertical-align: middle;
    }

    h2 {
        font-weight: bold;
        text-shadow: 1px 1px 0 #e9d8c5;
    }
</style>

<div class="container py-4">
    <h2 class="mb-4 text-center text-brown">🛒 Order Management</h2>

    <div class="card shadow-sm">
        <div class="card-header fw-bold text-brown">📋 Order List</div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Customer</th>
                        <th>Food Item</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Ordered At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $orders = [
                            ['id' => 1, 'user' => 'Alice', 'item' => 'Pepperoni Pizza', 'qty' => 2, 'total' => 20.00, 'status' => 'pending', 'time' => '2025-04-12 14:22'],
                            ['id' => 2, 'user' => 'Bob', 'item' => 'Cheese Burger', 'qty' => 1, 'total' => 8.50, 'status' => 'completed', 'time' => '2025-04-12 13:00'],
                            ['id' => 3, 'user' => 'Charlie', 'item' => 'Chicken Wings', 'qty' => 3, 'total' => 15.75, 'status' => 'cancelled', 'time' => '2025-04-11 18:45'],
                        ];
                    @endphp

                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order['id'] }}</td>
                            <td>{{ $order['user'] }}</td>
                            <td>{{ $order['item'] }}</td>
                            <td>{{ $order['qty'] }}</td>
                            <td>${{ number_format($order['total'], 2) }}</td>
                            <td>
                                <span class="badge 
                                    @if($order['status'] === 'pending') badge-pending
                                    @elseif($order['status'] === 'completed') badge-completed
                                    @else badge-cancelled @endif">
                                    {{ ucfirst($order['status']) }}
                                </span>
                            </td>
                            <td>{{ $order['time'] }}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <a href="#" class="btn btn-sm btn-danger">
                                    <i class="bi bi-x-circle"></i> Cancel
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
