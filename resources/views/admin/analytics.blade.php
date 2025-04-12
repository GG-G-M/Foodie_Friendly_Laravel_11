@extends('layouts.welcome_admin')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-brown">📊 Admin Analytics</h2>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary shadow">
                <div class="card-body">
                    <h5>Total Orders</h5>
                    <h3>{{ $totalOrders }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success shadow">
                <div class="card-body">
                    <h5>Total Sales</h5>
                    <h3>${{ number_format($totalSales, 2) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning shadow">
                <div class="card-body">
                    <h5>Top Item</h5>
                    <h3>{{ $topItem }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header fw-bold text-brown bg-white">Orders This Week</div>
        <div class="card-body">
            <canvas id="ordersChart" height="100"></canvas>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('ordersChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($days),
            datasets: [{
                label: 'Orders',
                data: @json($weeklyOrders),
                backgroundColor: '#6b4226'
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endsection
