<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        /* Gradient Background */
        body {
            background: linear-gradient(to bottom, #D2B48C, #A67B5B);
            min-height: 100vh;
            color: #5A3E36;
            padding-left: 220px; /* Matches sidebar width */
            transition: padding-left 0.3s ease;
        }
        /* Brand Title Styling */
        .brand-title {  
            text-align: center;
            font-size: 25px;
            font-weight: bold;
            color: white;
            padding: 10px 0;
            margin-bottom: 10px;
            font-family: 'Arial', sans-serif;
        }

        /* Sidebar Navigation */
        .side-nav {
            position: fixed;
            top: 0;
            left: 0;
            width: 220px;
            height: 100%;
            background: linear-gradient(to bottom, #8B4513, #A67B5B, #D2B48C);
            display: flex;
            flex-direction: column;
            padding-top: 20px;
            padding-left: 15px;
            box-shadow: 2px 0px 10px rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        /* Main Content Adjustment */
        .main-content {
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        /* Navigation Links */
        .nav-items {
            width: 100%;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 10px;
            color: #FAEBD7;
            text-decoration: none;
            font-size: 16px;
            transition: 0.3s;
        }

        .nav-item i {
            margin-right: 8px;
            font-size: 18px;
        }

        .nav-item:hover, .tracker-btn:hover, .logout-btn:hover {
            background-color: #5A3E36;
            color: white;
            border-radius: 5px;
        }

        /* Tracker Button */
        .tracker-btn {
            display: flex;
            align-items: center;
            padding: 10px;
            color: #FAEBD7;
            text-decoration: none;
            font-size: 16px;
            transition: 0.3s;
        }

        /* Logout Button */
        .logout-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 90%;
            padding: 10px;
            margin-top: auto;
            background:rgb(216, 127, 11);
            color: #5A3E36;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        .logout-btn i {
            margin-right: 8px;
        }

        .logout-btn:hover {
            background: #5A3E36;
            color: white;
        }
    </style>
</head>
<body>
        
    <div class="side-nav">
        <h3 class="brand-title">Foodie Friendly</h3>  

        <div class="nav-items">
        <a href="{{ route('home') }}" class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
    <i class="bi bi-house-door-fill"></i> Home
</a>
            <!-- <a href="#" class="nav-item">
                <i class="bi bi-search"></i> Search
            </a> -->
            <a href="{{ route('cart') }}" class="nav-item {{ request()->routeIs('cart') ? 'active' : '' }}"> <i class="bi bi-cart3"></i> Cart<span class="badge bg-brown rounded-pill ms-2">3</span></a>
           
            <a href="{{ route('tracker') }}" class="tracker-btn {{ request()->routeIs('tracker') ? 'active' : '' }}">
    <i class="bi bi-eye"></i> View Tracker
    <span class="badge bg-brown rounded-pill ms-2">3</span>
</a>
           
            <a href="{{ route('profile') }}" class="nav-item {{ request()->routeIs('profile') ? 'active' : '' }}"> <i class="bi bi-person"></i> Profile</a>
            <!-- Logout Link -->
            <a href="{{ route('logout') }}" 
            class="nav-item logout-link" 
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-right"></i> Logout
            </a>

            <!-- Hidden Logout Form -->
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>
    <div class="container-fluid px-0">
        @yield('content')
    </div>
</body>
</html>