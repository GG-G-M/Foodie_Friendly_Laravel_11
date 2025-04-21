@extends('layouts.welcome_admin')

@section('title', 'Sales Report')

@section('content')
    <div class="container-fluid px-4 py-2" style="background-color: #F4E1C1;"> <!-- Light brown background -->
        <!-- Summary Cards - Tight Layout -->
        <div class="row g-2 mb-3"> <!-- Increased gutter for spacing -->
            <div class="col-md-3">
                <div class="card border-0 shadow-sm p-3 h-100" style="background-color: #D8B69D;"> <!-- Light brown card background -->
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
                <div class="card border-0 shadow-sm p-3 h-100" style="background-color: #D8B69D;">
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
                <div class="card border-0 shadow-sm p-3 h-100" style="background-color: #D8B69D;">
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
                <div class="card border-0 shadow-sm p-3 h-100" style="background-color: #D8B69D;">
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
        <div class="row g-2 mb-3">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm p-3 h-100" style="background-color: #D8B69D;">
                    <h6 class="mb-1 px-3 text-dark">Weekly Sales Trend</h6>
                    <div style="height: 200px;">
                        <canvas id="weeklyChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm p-3 h-100" style="background-color: #D8B69D;">
                    <h6 class="mb-1 px-3 text-dark">Sales by Category</h6>
                    <div style="height: 200px;">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
<!-- Recent Orders - Organized and Modern Layout -->
<div class="card border-0 shadow-sm mb-3" style="background-color: #D8B69D;">
    <div class="card-body p-4">
        <h6 class="text-dark mb-4">Recent Orders</h6>

        <!-- Order #1 -->
        <div class="d-flex mb-3 p-3 rounded bg-light shadow-sm">
            <div class="me-3">
                <span class="badge" style="background-color: #D2B48C; color: white; font-size: 1.25rem;">#1001</span>
            </div>
            <div class="flex-grow-1">
                <div class="fw-bold">2 Pepperoni Pizzas</div>
                <div class="text-muted">Total: $31.98</div>
            </div>
            <div>
                <span class="badge bg-success">Completed</span>
            </div>
        </div>

        <!-- Order #2 -->
        <div class="d-flex mb-3 p-3 rounded bg-light shadow-sm">
            <div class="me-3">
                <span class="badge" style="background-color: #D2B48C; color: white; font-size: 1.25rem;">#1002</span>
            </div>
            <div class="flex-grow-1">
                <div class="fw-bold">Cheese Pizza + Drink</div>
                <div class="text-muted">Total: $16.50</div>
            </div>
            <div>
                <span class="badge bg-success">Completed</span>
            </div>
        </div>

        <!-- Order #3 -->
        <div class="d-flex mb-3 p-3 rounded bg-light shadow-sm">
            <div class="me-3">
                <span class="badge" style="background-color: #D2B48C; color: white; font-size: 1.25rem;">#1003</span>
            </div>
            <div class="flex-grow-1">
                <div class="fw-bold">Burger Meal</div>
                <div class="text-muted">Total: $14.25</div>
            </div>
            <div>
                <span class="badge bg-warning">Pending</span>
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
