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
        $currentOrder = Order::where('rider_id', Auth::id())
            ->where('status', 'delivering')
            ->with('orderItems.food', 'user')
            ->first();

        $pendingOrders = Order::whereNull('rider_id')
            ->where('status', 'pending')
            ->with('user')
            ->get();

        return view('rider.index', compact('currentOrder', 'pendingOrders'));
    }

    public function selectOrder(Request $request, Order $order)
    {
        if ($order->rider_id || $order->status !== 'pending') {
            return redirect()->route('rider.index')->with('error', 'Order is no longer available.');
        }

        $currentOrder = Order::where('rider_id', Auth::id())
            ->where('status', 'delivering')
            ->exists();

        if ($currentOrder) {
            return redirect()->route('rider.index')->with('error', 'You are already handling an order. Complete it first.');
        }

        $order->update([
            'rider_id' => Auth::id(),
            'status' => 'delivering',
            'delivery_started_at' => now(),
        ]);

        return redirect()->route('rider.index')->with('success', 'Order #' . $order->id . ' selected and delivery started.');
    }

    public function updateStatus(Request $request, Order $order)
    {
        if ($order->rider_id != Auth::id() || $order->status !== 'delivering') {
            return redirect()->route('rider.index')->with('error', 'Invalid order or status.');
        }

        $order->update([
            'status' => 'delivered',
            'delivery_completed_at' => now(),
        ]);

        return redirect()->route('rider.index')->with('success', 'Order #' . $order->id . ' marked as delivered.');
    }
}