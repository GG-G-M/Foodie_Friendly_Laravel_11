<?php

namespace App\Http\Controllers\Rider;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RiderDashboardController extends Controller
{
    public function index()
    {
        if (Auth::check() && Auth::user()->role !== 'rider') {
            abort(403, 'Unauthorized action.');
        }
        $rider = Auth::user()->rider;

        // Current Order
        $currentOrder = Order::where('rider_id', $rider->id)
                             ->where('status', 'delivering')
                             ->with('orderItems.food')
                             ->first();

        // Total Deliveries
        $totalDeliveries = Order::where('rider_id', $rider->id)
                                ->where('status', 'delivered')
                                ->count();

        // Total Earnings
        $deliveredOrders = Order::where('rider_id', $rider->id)
                                ->where('status', 'delivered')
                                ->get();
        $deliveryFee = DB::table('delivery_fees')->orderBy('date_added', 'desc')->first()->fee ?? 50.00;
        $totalEarnings = $deliveredOrders->sum(function ($order) use ($deliveryFee) {
            return $order->payment_method === 'Cash on Delivery' ? $deliveryFee : 0;
        });

        // Calculate total for current order
        $currentOrderTotal = $currentOrder ? $this->calculateOrderTotal($currentOrder) : 0;

        return view('rider.index', compact('currentOrder', 'totalDeliveries', 'totalEarnings', 'currentOrderTotal'));
    }

    protected function calculateOrderTotal($order)
    {
        $subtotal = $order->orderItems->sum(fn($item) => $item->price * $item->quantity);
        $deliveryFee = $order->payment_method === 'Cash on Delivery' ? 
            (DB::table('delivery_fees')->orderBy('date_added', 'desc')->first()->fee ?? 50.00) : 0;
        return $subtotal + $deliveryFee;
    }

    public function orders()
    {
        if (Auth::check() && Auth::user()->role !== 'rider') {
            abort(403, 'Unauthorized action.');
        }
        $rider = Auth::user()->rider;
        $currentOrder = Order::where('rider_id', $rider->id)
                             ->where('status', 'delivering')
                             ->with('orderItems.food')
                             ->first();

        $pendingOrders = Order::where('status', 'pending')
                              ->whereNull('rider_id')
                              ->with('orderItems.food')
                              ->get();

        // Calculate totals for pending orders
        $pendingOrderTotals = $pendingOrders->mapWithKeys(function ($order) {
            return [$order->id => $this->calculateOrderTotal($order)];
        })->toArray();

        $currentOrderTotal = $currentOrder ? $this->calculateOrderTotal($currentOrder) : 0;

        return view('rider.orders', compact('pendingOrders', 'currentOrder', 'pendingOrderTotals', 'currentOrderTotal'));
    }

    public function myDeliveries()
    {
        if (Auth::check() && Auth::user()->role !== 'rider') {
            abort(403, 'Unauthorized action.');
        }
        $rider = Auth::user()->rider;
        $deliveredOrders = Order::where('rider_id', $rider->id)
                                ->whereIn('status', ['delivered', 'cancelled'])
                                ->orderBy('updated_at', 'desc')
                                ->with('orderItems.food')
                                ->get();

        return view('rider.my-deliveries', compact('deliveredOrders'));
    }

    public function earnings()
    {
        if (Auth::check() && Auth::user()->role !== 'rider') {
            abort(403, 'Unauthorized action.');
        }
        $rider = Auth::user()->rider;
        $deliveredOrders = Order::where('rider_id', $rider->id)
                                ->where('status', 'delivered')
                                ->with('orderItems.food')
                                ->get();

        $deliveryFee = DB::table('delivery_fees')->orderBy('date_added', 'desc')->first()->fee ?? 50.00;
        $totalEarnings = $deliveredOrders->sum(function ($order) use ($deliveryFee) {
            return $order->payment_method === 'Cash on Delivery' ? $deliveryFee : 0;
        });

        return view('rider.earnings', compact('deliveredOrders', 'totalEarnings'));
    }

    public function showProfile()
    {
        if (Auth::check() && Auth::user()->role !== 'rider') {
            abort(403, 'Unauthorized action.');
        }
        $user = Auth::user();
        return view('rider.profile-show', compact('user'));
    }

    public function editProfile()
    {
        if (Auth::check() && Auth::user()->role !== 'rider') {
            abort(403, 'Unauthorized action.');
        }
        $user = Auth::user();
        return view('rider.profile', compact('user')); // Note: 'profile' is the edit view for riders
    }

    public function startDelivery(Request $request, Order $order)
    {
        if (Auth::check() && Auth::user()->role !== 'rider') {
            abort(403, 'Unauthorized action.');
        }
        if ($order->status !== 'pending' || $order->rider_id) {
            return redirect()->route('rider.orders')->with('error', 'This order is already taken or not available.');
        }

        $rider = Auth::user()->rider;

        $currentOrder = Order::where('rider_id', $rider->id)
                            ->where('status', 'delivering')
                            ->first();

        if ($currentOrder) {
            return redirect()->route('rider.orders')->with('error', 'You are already handling an order. Please complete it first.');
        }

        $order->update([
            'rider_id' => $rider->id,
            'status' => 'delivering',
        ]);

        return redirect()->route('rider.orders')->with('success', 'Order delivery started successfully!');
    }

    public function finishDelivery(Request $request, Order $order)
    {
        if (Auth::check() && Auth::user()->role !== 'rider') {
            abort(403, 'Unauthorized action.');
        }
        if ($order->status !== 'delivering' || $order->rider_id !== Auth::user()->rider->id) {
            return redirect()->route('rider.index')->with('error', 'You cannot finish this order.');
        }

        $order->update([
            'status' => 'delivered',
        ]);

        return redirect()->route('rider.index')->with('success', 'Order delivered successfully!');
    }
}