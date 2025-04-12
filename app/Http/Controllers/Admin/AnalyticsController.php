<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function index()
    {
        // Your dummy data
        $orders = [
            ['item' => 'Pepperoni Pizza', 'price' => 15.99, 'date' => '2025-04-06'],
            ['item' => 'Cheese Pizza', 'price' => 13.50, 'date' => '2025-04-07'],
            ['item' => 'Burger', 'price' => 11.25, 'date' => '2025-04-08'],
        ];

        $totalOrders = count($orders);
        $totalSales = array_sum(array_column($orders, 'price'));
        $topItem = 'Pepperoni Pizza'; // Or logic to determine top item
        $weeklyOrders = [12, 18, 25, 20, 30, 15, 5]; // Dummy weekly orders
        $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

        return view('admin.analytics', compact('totalOrders', 'totalSales', 'topItem', 'weeklyOrders', 'days'));
    }
}