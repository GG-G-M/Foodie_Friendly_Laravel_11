@extends('layouts.welcome_admin')

@section('title', 'Sales Report')

@section('content')
    <div class="container-fluid px-2 py-1"> <!-- Ultra-compact padding -->
        <!-- Summary Cards - Tight Layout -->
        <div class="row g-1 mb-2"> <!-- Minimal gutter -->
            <div class="col-md-3">
                <div class="card border-0 shadow-sm p-2 h-100"> <!-- Reduced padding -->
                    <div class="d-flex align-items-center">
                        <i class="fas fa-dollar-sign text-primary me-2"></i>
                        <div>
                            <small class="text-muted d-block">Total Sales</small>
                            <strong>${{ number_format($totalSales, 2) }}</strong>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm p-2 h-100">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-receipt text-success me-2"></i>
                        <div>
                            <small class="text-muted d-block">Total Orders</small>
                            <strong>{{ $totalOrders }}</strong>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm p-2 h-100">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-calculator text-info me-2"></i>
                        <div>
                            <small class="text-muted d-block">Avg. Order</small>
                            <strong>${{ number_format($avgOrder, 2) }}</strong>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm p-2 h-100">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-star text-warning me-2"></i>
                        <div>
                            <small class="text-muted d-block">Popular Item</small>
                            <strong>{{ $popularItem }} ({{ $popularCount }})</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts - Compact -->
        <div class="row g-1 mb-2">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm p-2 h-100">
                    <h6 class="mb-1 px-2">Weekly Sales Trend</h6>
                    <div style="height:200px">
                        <canvas id="weeklyChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm p-2 h-100">
                    <h6 class="mb-1 px-2">Sales by Category</h6>
                    <div style="height:200px">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders - Ultra Compact -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-2">
                <h6 class="mb-1">Recent Orders</h6>
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Items</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#1001</td>
                                <td>2 Pepperoni Pizzas</td>
                                <td>$31.98</td>
                                <td><span class="badge bg-success">Completed</span></td>
                            </tr>
                            <tr>
                                <td>#1002</td>
                                <td>Cheese Pizza + Drink</td>
                                <td>$16.50</td>
                                <td><span class="badge bg-success">Completed</span></td>
                            </tr>
                            <tr>
                                <td>#1003</td>
                                <td>Burger Meal</td>
                                <td>$14.25</td>
                                <td><span class="badge bg-warning">Pending</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Weekly Chart
    new Chart(document.getElementById('weeklyChart'), {
        type: 'bar',
        data: {
            labels: @json($weeklySales['labels']),
            datasets: [{
                data: @json($weeklySales['data']),
                backgroundColor: '#36A2EB',
                borderColor: '#228BCC',
                borderWidth: 1
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { 
                    beginAtZero: true,
                    ticks: { callback: v => '$'+v }
                }
            }
        }
    });

    // Category Chart
    new Chart(document.getElementById('categoryChart'), {
        type: 'doughnut',
        data: {
            labels: @json(collect($categories)->pluck('name')),
            datasets: [{
                data: @json(collect($categories)->pluck('sales')),
                backgroundColor: @json(collect($categories)->pluck('color'))
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'right' },
                tooltip: {
                    callbacks: {
                        label: ctx => `${ctx.label}: $${ctx.raw} (${Math.round(ctx.parsed)}%)`
                    }
                }
            }
        }
    });
</script>
@endsection
@endsection