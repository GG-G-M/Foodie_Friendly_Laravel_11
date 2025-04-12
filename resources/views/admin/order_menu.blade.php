@extends('layouts.welcome_admin')

@section('content')
<style>
    .text-brown { color: #6b4226; }
    .badge-pending { background-color: #ffc107; }
    .badge-completed { background-color: #28a745; }
    .badge-cancelled { background-color: #dc3545; }
</style>

<div class="container py-4">
    <h2 class="mb-4 text-brown">🛒 Order Management</h2>

    <div class="card shadow-sm">
        <div class="card-header bg-white fw-bold text-brown">Order List</div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
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
                                <a href="#" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i> View</a>
                                <a href="#" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> Cancel</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
