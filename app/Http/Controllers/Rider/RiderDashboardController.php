<?php

namespace App\Http\Controllers\Rider;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Rider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiderDashboardController extends Controller
{
    public function index()
    {
        $rider = Rider::where('user_id', Auth::id())->first();

        if (!$rider) {
            return redirect()->route('rider.index')->with('error', 'Rider profile not found. Please contact the admin.');
        }

        $currentOrder = Order::where('rider_id', $rider->id)
            ->where('status', 'delivering')
            ->with('orderItems.food', 'user')
            ->first();

        if ($currentOrder) {
            $subtotal = $currentOrder->orderItems->sum(fn($item) => $item->price * $item->quantity);
            $deliveryFee = 50;
            $tax = $subtotal * 0.1;
            $currentOrder->display_total = ($currentOrder->payment_method === 'Cash on Delivery') ? ($subtotal + $deliveryFee + $tax) : 0;
        }

        $pendingOrders = Order::whereNull('rider_id')
            ->where('status', 'pending')
            ->with('user', 'orderItems')
            ->get()
            ->map(function ($order) {
                $subtotal = $order->orderItems->sum(fn($item) => $item->price * $item->quantity);
                $deliveryFee = 50;
                $tax = $subtotal * 0.1;
                $order->display_total = ($order->payment_method === 'Cash on Delivery') ? ($subtotal + $deliveryFee + $tax) : 0;
                return $order;
            });

        return view('rider.index', compact('currentOrder', 'pendingOrders'));
    }

    public function startDelivery(Request $request, Order $order)
    {
        if ($order->rider_id || $order->status !== 'pending') {
            return redirect()->route('rider.index')->with('error', 'Order is no longer available.');
        }

        $rider = Rider::where('user_id', Auth::id())->first();

        if (!$rider) {
            return redirect()->route('rider.index')->with('error', 'Rider profile not found. Please contact the admin.');
        }

        $currentOrder = Order::where('rider_id', $rider->id)
            ->where('status', 'delivering')
            ->exists();

        if ($currentOrder) {
            return redirect()->route('rider.index')->with('error', 'You are already handling an order. Complete it first.');
        }

        $order->update([
            'rider_id' => $rider->id,
            'status' => 'delivering',
            'delivery_started_at' => now(),
        ]);

        return redirect()->route('rider.index')->with('success', 'Order #' . $order->id . ' delivery started.');
    }

    public function finishDelivery(Request $request, Order $order)
    {
        $rider = Rider::where('user_id', Auth::id())->first();

        if (!$rider || $order->rider_id != $rider->id || $order->status !== 'delivering') {
            return redirect()->route('rider.index')->with('error', 'Invalid order or status.');
        }

        $order->update([
            'status' => 'delivered',
            'delivery_completed_at' => now(),
        ]);

        return redirect()->route('rider.index')->with('success', 'Order #' . $order->id . ' marked as delivered.');
    }
}