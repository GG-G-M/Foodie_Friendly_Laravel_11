@extends('layouts.welcome_admin')

@section('title', 'Sales Report')

@section('content')
<!-- Font Awesome CDN for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<div class="container py-4" style="background-color: #f4ece3; border-radius: 15px;">
    <h2 class="mb-4 text-center" style="color: #5D3A00;"><i class="fas fa-chart-bar me-2"></i> Sales Report</h2>

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

    <!-- Date Filter Form -->
    <div class="card shadow-sm mb-4" style="background-color: #fff7f0;">
        <div class="card-body">
            <h5 style="color: #5D3A00;"><i class="fas fa-filter me-2"></i> Filter Sales by Date</h5>
            <form action="{{ route('admin.sales_report.filter') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-5 mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}" required>
                    </div>
                    <div class="col-md-5 mb-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}" required>
                    </div>
                    <div class="col-md-2 mb-3 d-flex align-items-end">
                        <button type="submit" class="btn w-100" style="background-color: #d2b48c; color: white;">
                            <i class="fas fa-search me-1"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row g-2 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm h-100" style="background-color: #fff7f0;">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-dollar-sign text-primary me-2" style="font-size: 1.5rem;"></i>
                    <div>
                        <small class="text-muted d-block">Total Sales</small>
                        <strong>₱{{ number_format($totalSales, 2) }}</strong>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm h-100" style="background-color: #fff7f0;">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-receipt text-success me-2" style="font-size: 1.5rem;"></i>
                    <div>
                        <small class="text-muted d-block">Total Orders</small>
                        <strong>{{ $totalOrders }}</strong>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm h-100" style="background-color: #fff7f0;">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-calculator text-info me-2" style="font-size: 1.5rem;"></i>
                    <div>
                        <small class="text-muted d-block">Avg. Order</small>
                        <strong>₱{{ number_format($avgOrder, 2) }}</strong>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm h-100" style="background-color: #fff7f0;">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-star text-warning me-2" style="font-size: 1.5rem;"></i>
                    <div>
                        <small class="text-muted d-block">Popular Item</small>
                        <strong>{{ $popularItem }} ({{ $popularCount }})</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="row g-2 mb-4">
        <div class="col-lg-8">
            <div class="card shadow-sm h-100" style="background-color: #fff7f0;">
                <div class="card-body">
                    <h6 style="color: #5D3A00;">Weekly Sales Trend</h6>
                    <div style="height: 300px;">
                        <canvas id="weeklyChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow-sm h-100" style="background-color: #fff7f0;">
                <div class="card-body">
                    <h6 style="color: #5D3A00;">Sales by Category</h6>
                    <div style="height: 300px;">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="card shadow-sm" style="background-color: #fff7f0;">
        <div class="card-body">
            <h6 style="color: #5D3A00; margin-bottom: 1.5rem;">Recent Orders</h6>
            @if($recentOrders->isEmpty())
                <p class="text-center">No recent orders available.</p>
            @else
                @foreach($recentOrders as $order)
                    @php
                        $totalAmount = $order->total_amount + ($order->delivery_fee ?? 0.00);
                    @endphp
                    <div class="d-flex mb-3 p-3 rounded bg-light shadow-sm">
                        <div class="me-3">
                            <span class="badge" style="background-color: #d2b48c; color: white; font-size: 1.25rem;">#{{ $order->id }}</span>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-bold">
                                @foreach($order->orderItems as $item)
                                    {{ $item->quantity }} {{ $item->food->name }}{{ $loop->last ? '' : ', ' }}
                                @endforeach
                            </div>
                            <div class="text-muted">Total: ₱{{ number_format($totalAmount, 2) }}</div>
                        </div>
                        <div>
                            <span class="badge {{ $order->status === 'delivered' ? 'bg-success' : 'bg-warning' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
    // Debug: Log the data to ensure it's being passed correctly
    console.log('Weekly Sales Data:', @json($weeklySales));
    console.log('Categories Data:', @json($categories));

    // Weekly Sales Trend (Bar Graph)
    const weeklyChartCtx = document.getElementById('weeklyChart').getContext('2d');
    new Chart(weeklyChartCtx, {
        type: 'bar',
        data: {
            labels: @json($weeklySales['labels']),
            datasets: [{
                label: 'Sales',
                data: @json($weeklySales['data']),
                backgroundColor: '#d2b48c',
                borderColor: '#a97c50',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return '₱' + context.parsed.y.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '₱' + value.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                        }
                    }
                }
            }
        }
    });

    // Sales by Category (Pie Chart)
    const categoryChartCtx = document.getElementById('categoryChart').getContext('2d');
    new Chart(categoryChartCtx, {
        type: 'pie',
        data: {
            labels: @json(collect($categories)->pluck('name')),
            datasets: [{
                label: 'Sales by Category',
                data: @json(collect($categories)->pluck('sales')),
                backgroundColor: @json(collect($categories)->pluck('color')),
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        boxWidth: 20,
                        padding: 15
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `${context.label}: ₱${context.raw.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
@endsection