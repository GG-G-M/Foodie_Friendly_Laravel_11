<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rider Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #ffffff;
        }

        .side-navbar {
            height: 100vh;
            width: 250px;
            background-color: #5d4037; /* brown */
            padding: 20px;
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
        }

        .side-navbar a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }

        .side-navbar a:hover {
            background-color: #795548; /* lighter brown on hover */
        }

        .main-content {
            margin-left: 250px;
            padding: 40px 20px;
            min-height: 100vh;
            background-color: #ffffff;
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 20px;
            }

            .side-navbar {
                position: relative;
                width: 100%;
                height: auto;
                border-radius: 0;
            }
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="side-navbar">
        <h4 class="text-white">Rider Panel</h4>
        <a href="#">Dashboard</a>
        <a href="#">Available Orders</a>
        <a href="#">My Deliveries</a>
        <a href="#">Earnings</a>
        <a href="#">Profile</a>
        <a href="#">Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main-content d-flex justify-content-center align-items-start">
        <div class="container" style="max-width: 800px;">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
