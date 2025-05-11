<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Foodie Friendly')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .bg-brown { background: linear-gradient(to bottom, #8B4513, #A67B5B); }
        .text-brown { color: #8B4513; }
        .btn-brown {
            background-color: #A67B5B;
            border-color: #8B4513;
            color: white;
        }
        .btn-brown:hover {
            background-color: #8B4513;
            color: white;
        }
        body { background-color: #f8f1e9; }

        .sidebar {
            min-height: 100vh;
            width: 240px;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1030;
        }

        .main-content {
            margin-left: 240px;
            padding: 20px;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: relative;
                width: 100%;
                min-height: auto;
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="d-flex flex-column flex-md-row">
        <!-- Sidebar -->
        <nav class="sidebar bg-brown p-3">
            <a class="navbar-brand text-white mb-4 fs-4 d-block" href="{{ route('home') }}">
                <i class="bi bi-shop me-2"></i>Foodie Friendly
            </a>
         <ul class="nav nav-pills flex-column">
    @auth
        @if (Auth::user()->role === 'admin')
            <li class="nav-item"><a href="{{ route('admin.dashboard') }}" class="nav-link text-white"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
            <li><a href="{{ route('admin.order_categories') }}" class="nav-link text-white"><i class="bi bi-basket me-2"></i>Manage Food</a></li>
            <li><a href="{{ route('admin.order_menu') }}" class="nav-link text-white"><i class="bi bi-receipt-cutoff me-2"></i>Orders</a></li>
            <li><a href="{{ route('admin.riders.index') }}" class="nav-link text-white"><i class="bi bi-bicycle me-2"></i>Riders</a></li>
            <li><a href="{{ route('admin.sales_report') }}" class="nav-link text-white"><i class="bi bi-graph-up-arrow me-2"></i>Sales Report</a></li>
        @else
            <li><a href="{{ route('home') }}" class="nav-link text-white"><i class="bi bi-card-list me-2"></i>Food Menu</a></li>
            <li><a href="{{ route('cart') }}" class="nav-link text-white"><i class="bi bi-cart me-2"></i>Cart</a></li>
            <li><a href="{{ route('order-history') }}" class="nav-link text-white"><i class="bi bi-clock-history me-2"></i>My Orders</a></li>
            <li><a href="{{ route('profile') }}" class="nav-link text-white"><i class="bi bi-person-circle me-2"></i>Profile</a></li>
        @endif
    @else
        <li><a href="{{ route('login') }}" class="nav-link text-white"><i class="bi bi-box-arrow-in-right me-2"></i>Login</a></li>
        <li><a href="{{ route('register') }}" class="nav-link text-white"><i class="bi bi-pencil-square me-2"></i>Register</a></li>
    @endauth

    <li><a href="{{ route('about') }}" class="nav-link text-white"><i class="bi bi-info-circle me-2"></i>About</a></li>

    @auth
        <li>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="nav-link btn btn-link text-white ps-0 text-start">
                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                </button>
            </form>
        </li>
    @endauth
</ul>

        </nav>

        <!-- Main Content -->
        <div class="main-content flex-grow-1">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
