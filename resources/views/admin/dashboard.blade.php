@extends('layouts.welcome_admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="admin-header">
    <h1>Dashboard Overview</h1>
    <div class="text-muted">Welcome back, Administrator!</div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="admin-card">
            <div class="card-body">
                <h5 class="card-title">Total Users</h5>
                <p class="display-4">{{ $totalUsers }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="admin-card">
            <div class="card-body">
                <h5 class="card-title">Total Orders</h5>
                <p class="display-4">{{ $totalOrders }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="admin-card">
            <div class="card-body">
                <h5 class="card-title">Total Revenue</h5>
                <p class="display-4">${{ number_format($totalRevenue, 2) }}</p>
            </div>
        </div>
    </div>
</div>

<div class="admin-card mt-4">
    <div class="card-body">
        <h5 class="card-title">Recent Activity</h5>
        <!-- Recent activity content here -->
    </div>
</div>
@endsection