<?php

namespace App\Http\Controllers\Rider;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiderDashboardController extends Controller
{
    public function index()
    {
        $availableOrders = Order::where('status', 'pending')
            ->whereNull('rider_id') // Changed from 'riderID'
            ->with('user', 'orderItems.food')
            ->paginate(10);

        $myOrders = Order::where('rider_id', Auth::id()) // Changed from 'riderID'
            ->whereIn('status', ['delivering'])
            ->with('user', 'orderItems.food')
            ->paginate(10);

        return view('rider.dashboard', compact('availableOrders', 'myOrders'));
    }

    public function selectOrder(Order $order)
    {
        if ($order->status !== 'pending' || $order->rider_id) { // Changed from 'riderID'
            return redirect()->route('rider.dashboard')->with('error', 'This order is not available for delivery.');
        }

        $order->update([
            'rider_id' => Auth::id(), // Changed from 'riderID'
            'status' => 'delivering',
        ]);

        return redirect()->route('rider.dashboard')->with('success', 'Order selected for delivery!');
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:delivering,delivered',
        ]);

        if ($order->rider_id !== Auth::id()) { // Changed from 'riderID'
            return redirect()->route('rider.dashboard')->with('error', 'You are not assigned to this order.');
        }

        $order->update(['status' => $request->status]);

        return redirect()->route('rider.dashboard')->with('success', 'Order status updated successfully!');
    }
}