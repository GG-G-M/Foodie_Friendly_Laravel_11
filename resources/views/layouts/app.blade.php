<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Foodie Friendly')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .bg-brown { background: linear-gradient(to right, #8B4513, #A67B5B); }
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
        .border-brown { border-color: #8B4513 !important; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-brown">
        <div class="container">
            <a class="navbar-brand text-white" href="{{ route('home') }}">Foodie Friendly</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        @if (Auth::user()->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('admin.order_categories') }}">Manage Food</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('admin.order_menu') }}">Orders</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('admin.riders.index') }}">Riders</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('admin.sales_report') }}">Sales Report</a>
                            </li>
                        @elseif (Auth::user()->role === 'customer')
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('home') }}">Food Menu</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('cart') }}">Cart</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('order-history') }}">My Orders</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('tracker') }}">Track Order</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('profile') }}">Profile</a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="nav-link btn btn-link text-white">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('register') }}">Register</a>
                        </li>
                    @endauth
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('about') }}">About</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="py-4">
        @yield('content')
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>