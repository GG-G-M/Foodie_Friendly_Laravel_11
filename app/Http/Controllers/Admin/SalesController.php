<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class SalesController extends Controller
{
    public function index()
    {
        // Enhanced dummy data
        return view('admin.sales_report', [
            'weeklySales' => [
                'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                'data' => [1250, 1890, 1520, 2080, 1680, 2240, 1950]
            ],
            'categories' => [
                ['name' => 'Pizza', 'sales' => 4250, 'color' => '#FF6384'],
                ['name' => 'Burgers', 'sales' => 3250, 'color' => '#36A2EB'],
                ['name' => 'Drinks', 'sales' => 1850, 'color' => '#FFCE56'],
                ['name' => 'Sides', 'sales' => 1250, 'color' => '#4BC0C0']
            ],
            'totalSales' => 10640,
            'totalOrders' => 142,
            'avgOrder' => 74.93,
            'popularItem' => 'Pepperoni Pizza',
            'popularCount' => 68
        ]);
    }
}