<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rider Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    {{-- Add any other global styles or scripts here --}}
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="bg-yellow-800 text-white w-64 p-6">
            <h2 class="text-3xl font-semibold mb-8">Rider Panel</h2>
            <ul>
                <li class="mb-4">
                    <a href="{{ route('rider.dashboard') }}" class="text-lg hover:text-yellow-300">Dashboard</a>
                </li>
                <li class="mb-4">
                    <a href="#" class="text-lg hover:text-yellow-300">Profile</a>
                </li>
                <li class="mb-4">
                    <a href="#" class="text-lg hover:text-yellow-300">Deliveries</a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('logout') }}" class="text-lg hover:text-yellow-300">Logout</a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6">
            @yield('content')  {{-- This will display the content from child views --}}
        </div>
    </div>
</body>
</html>
