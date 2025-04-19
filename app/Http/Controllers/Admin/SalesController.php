<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Food;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SalesController extends Controller
{
    public function index()
    {
        // Get sales data for the last 30 days
        $startDate = Carbon::now()->subDays(30);
        $endDate = Carbon::now();
        
        // Total sales calculation
        $totalSales = Order::whereBetween('created_at', [$startDate, $endDate])
                          ->sum('total_price');
        
        // Total orders count
        $totalOrders = Order::whereBetween('created_at', [$startDate, $endDate])
                          ->count();
        
        // Daily sales data for line chart
        $dailySales = Order::whereBetween('created_at', [$startDate, $endDate])
                         ->selectRaw('DATE(created_at) as date, SUM(total_price) as total')
                         ->groupBy('date')
                         ->orderBy('date')
                         ->get();
        
        // Prepare data for the line chart
        $lineChartData = [
            'labels' => $dailySales->pluck('date')->map(function ($date) {
                return Carbon::parse($date)->format('M d');
            }),
            'data' => $dailySales->pluck('total')
        ];
        
        // Weekly sales data
        $weeklySales = Order::whereBetween('created_at', [$startDate, $endDate])
                          ->selectRaw('WEEK(created_at) as week, SUM(total_price) as total')
                          ->groupBy('week')
                          ->orderBy('week')
                          ->get();
        
        // Top selling items (pie chart data)
        $topItems = Food::withCount(['orders as total_ordered' => function($query) use ($startDate, $endDate) {
                            $query->whereBetween('orders.created_at', [$startDate, $endDate]);
                        }])
                       ->orderByDesc('total_ordered')
                       ->take(5)
                       ->get();
        
        // Sales by category (bar chart data)
        $salesByCategory = Food::withSum(['orders as total_sales' => function($query) use ($startDate, $endDate) {
                                $query->whereBetween('orders.created_at', [$startDate, $endDate]);
                            }], 'orders.total_price')
                             ->groupBy('category')
                             ->selectRaw('category, SUM(total_sales) as total')
                             ->orderByDesc('total')
                             ->get();
        
        // Recent orders
        $recentOrders = Order::with('user')
                           ->latest()
                           ->take(5)
                           ->get();
        
        return view('admin.sales_report', compact(
            'totalSales',
            'totalOrders',
            'lineChartData',
            'weeklySales',
            'topItems',
            'salesByCategory',
            'recentOrders'
        ));
    }

    public function filter(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);
        
        // Similar logic as index() but with custom date range
        $startDate = Carbon::parse($validated['start_date']);
        $endDate = Carbon::parse($validated['end_date']);
        
        // Rest of the logic would be the same as index() but with the custom date range
        // You could refactor this into a separate method to avoid duplication
        
        return redirect()->route('admin.sales_report')->withInput();
    }
}