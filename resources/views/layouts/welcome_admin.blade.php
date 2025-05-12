<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<!-- Admin Sidebar -->
<div class="admin-sidebar">
    <div class="brand">Foodie Friendly Admin</div>
    <nav class="nav flex-column">
        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-home"></i> Dashboard
        </a>
        <a class="nav-link {{ request()->routeIs('admin.user_management') ? 'active' : '' }}" href="{{ route('admin.user_management') }}">
            <i class="fas fa-users"></i> User Management
        </a>
        <a class="nav-link {{ request()->routeIs('admin.order_categories') ? 'active' : '' }}" href="{{ route('admin.order_categories') }}">
            <i class="fas fa-shopping-cart"></i> Order Categories
        </a>
        <a class="nav-link {{ request()->routeIs('admin.order_menu') ? 'active' : '' }}" href="{{ route('admin.order_menu') }}">
            <i class="fas fa-clipboard-list"></i> Order Menu
        </a>
        <a class="nav-link {{ request()->routeIs('admin.sales_report.index') ? 'active' : '' }}" href="{{ route('admin.sales_report.index') }}">
            <i class="fas fa-chart-bar"></i> Sales Report
        </a>

        <!-- Logout Button (Moved under Sales Report) -->
        <form action="{{ route('logout') }}" method="POST" class="mt-auto p-3">
            @csrf
            <button type="submit" class="nav-link text-start w-100 bg-transparent border-0">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
    </nav>
</div>

<!-- Main Content -->
<main class="admin-main">
    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')

<style>
    :root {
        --sidebar-width: 250px;
        --primary-color: #5A3E36;
        --secondary-color: #8B4513;
        --light-color: #FAEBD7;
    }
    
    body {
        display: flex;
        min-height: 100vh;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f8f9fa;
        margin: 0;
    }

    /* Sidebar Styles */
    .admin-sidebar {
        width: var(--sidebar-width);
        background: linear-gradient(to bottom, #D2B48C, #E0C097);
        padding: 20px 0;
        border-right: 2px solid var(--primary-color);
        box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        position: fixed;
        height: 100vh;
    }

    .admin-sidebar .brand {
        color: var(--primary-color);
        text-align: center;
        padding: 15px;
        font-weight: bold;
        font-size: 1.2rem;
        border-bottom: 1px solid rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }

    .admin-sidebar .nav-link {
        color: var(--primary-color);
        padding: 12px 20px;
        margin: 5px 10px;
        border-radius: 5px;
        transition: all 0.3s;
        display: flex;
        align-items: center;
    }

    .admin-sidebar .nav-link:hover,
    .admin-sidebar .nav-link.active {
        background-color: var(--secondary-color);
        color: white;
    }

    .admin-sidebar .nav-link i {
        margin-right: 10px;
        width: 20px;
        text-align: center;
    }

    /* Main Content Area */
    .admin-main {
        margin-left: var(--sidebar-width);
        padding: 20px;
        width: calc(100% - var(--sidebar-width));
        background-color: white;
        min-height: 100vh;
    }

    .admin-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
        margin-bottom: 30px;
    }

    .admin-card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        transition: transform 0.3s;
        margin-bottom: 20px;
    }

    .admin-card:hover {
        transform: translateY(-5px);
    }

    .admin-card .card-body {
        padding: 20px;
    }

    /* Logout Button Adjustment */
    .admin-sidebar form {
        margin-top: auto;
    }

    .admin-sidebar form button {
        color: var(--primary-color);
        padding: 12px 20px;
        margin: 5px 10px;
        border-radius: 5px;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        background-color: transparent;
        border: 0;
    }

    .admin-sidebar form button:hover {
        background-color: var(--secondary-color);
        color: white;
    }
</style>
@stack('styles')
</body>
</html>