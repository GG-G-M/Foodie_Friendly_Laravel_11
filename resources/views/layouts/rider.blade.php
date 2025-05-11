<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        body {
            background-color: #f5f5f5;
            display: flex;
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        /* Side Navbar Styles */
        .side-navbar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 250px;
            background-color: #fff;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            padding-top: 20px;
            border-radius: 0 15px 15px 0;
        }

        .side-navbar .navbar-brand {
            color: #8b5e3c;
            font-size: 1.7rem;
            font-weight: bold;
            padding: 10px 20px;
            margin-bottom: 30px;
        }

        .side-navbar .navbar-brand:hover {
            color: #6b4e31;
        }

        .side-navbar .nav-link {
            color: #5D3A00;
            padding: 12px 20px;
            font-size: 1.1rem;
            font-weight: 500;
        }

        .side-navbar .nav-link:hover {
            color: #fff;
            background-color: #8b5e3c;
            border-radius: 5px;
        }

        .side-navbar .nav-link.active {
            background-color: #6b4e31;
            color: white;
        }

        /* Main Content Styling */
        .main-content {
            margin-left: 250px;
            padding: 30px;
            background-color: #f8f9fa;
            flex-grow: 1;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .container {
            max-width: 100%;
        }

        /* Adjust card design for profile page */
        .card {
            border-radius: 15px;
        }

        .card-header {
            background: linear-gradient(to right, #8B4513, #A67B5B);
            color: white;
            font-weight: bold;
        }

        .btn-brown {
            background-color: #8b5e3c;
            color: white;
        }

        .btn-brown:hover {
            background-color: #6b4e31;
            color: white;
        }

        /* Profile styling */
        .profile-pic {
            border-radius: 50%;
            width: 120px;
            height: 120px;
        }

        .profile-info .list-group-item {
            background-color: #fff;
            border: none;
        }

        /* Footer styling */
        footer {
            padding: 20px;
            background-color: #8b5e3c;
            color: white;
            text-align: center;
            margin-top: 30px;
            border-radius: 0 0 15px 15px;
        }

    </style>
</head>
<body>

    <!-- Side Navbar -->
    <div class="side-navbar">
        <div class="container">
            <a class="navbar-brand" href="{{ route('rider.index') }}">🏍️ Rider Dashboard</a>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link text-brown @if(request()->routeIs('rider.index')) active @endif" href="{{ route('rider.index') }}">
                        <i class="bi bi-house-door me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-brown @if(request()->routeIs('rider.profile')) active @endif" href="{{ route('rider.profile') }}">
                        <i class="bi bi-person-circle me-2"></i> Profile
                    </a>
                </li>
                <!-- Add more links here -->
            </ul>

            <!-- Logout Button -->
            <form action="{{ route('logout') }}" method="POST" class="mt-4">
                @csrf
                <button type="submit" class="btn btn-outline-brown w-100">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Rider Dashboard | All Rights Reserved</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
