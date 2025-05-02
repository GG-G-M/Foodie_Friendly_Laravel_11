<?php

namespace App\Http\Controllers\Rider;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiderController extends Controller
{
    /**
     * Display a list of orders assigned to the rider that are ready for delivery.
     */
    public function index()
    {
        $orders = Order::where('rider_id', Auth::id())
            ->where('status', 'pending')
            ->with('orderItems.food', 'user')
            ->get();

        return view('rider.index', compact('orders'));
    }

    /**
     * Start the delivery of a selected order.
     */
    public function startDelivery(Request $request, $id)
    {
        $order = Order::where('id', $id)
            ->where('rider_id', Auth::id())
            ->where('status', 'pending')
            ->firstOrFail();

        $order->update([
            'status' => 'delivering',
            'delivery_started_at' => now(),
        ]);

        return redirect()->route('rider.index')->with('success', 'Delivery started for Order #' . $order->id);
    }

    /**
     * Complete the delivery of a selected order.
     */
    public function completeDelivery(Request $request, $id)
    {
        $order = Order::where('id', $id)
            ->where('rider_id', Auth::id())
            ->where('status', 'delivering')
            ->firstOrFail();

        $order->update([
            'status' => 'delivered',
            'delivery_completed_at' => now(),
        ]);

        return redirect()->route('rider.index')->with('success', 'Delivery completed for Order #' . $order->id);
    }
}