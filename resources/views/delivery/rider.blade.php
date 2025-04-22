@extends('layouts.rider_dashboard')

@section('content')
<div class="container mx-auto p-6">
    <!-- Delivery Page Content -->
    <div class="bg-white shadow-md rounded-2xl p-6 mb-6 border-l-8 border-yellow-800">
        <h1 class="text-2xl font-semibold text-yellow-900 mb-4">Deliveries</h1>

        <!-- Deliveries Table -->
        <div class="bg-white border rounded-xl shadow p-4">
            <table class="w-full text-left border-collapse">
                <thead class="bg-yellow-200 text-yellow-900">
                    <tr>
                        <th class="p-2">Order ID</th>
                        <th class="p-2">Customer</th>
                        <th class="p-2">Address</th>
                        <th class="p-2">Status</th>
                        <th class="p-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($deliveries as $delivery)
                        <tr class="border-b hover:bg-yellow-50">
                            <td class="p-2">{{ $delivery->order_id }}</td>
                            <td class="p-2">{{ $delivery->customer_name }}</td>
                            <td class="p-2">{{ $delivery->address }}</td>
                            <td class="p-2 text-yellow-700 font-semibold">{{ $delivery->status }}</td>
                            <td class="p-2">
                                <a href="{{ route('deliveries.show', $delivery->id) }}" class="text-blue-600 hover:underline">View</a>
                                @if($delivery->status === 'Pending')
                                    <a href="{{ route('deliveries.markAsCompleted', $delivery->id) }}" class="text-green-600 hover:underline ml-4">Mark as Completed</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
