<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Services\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Process the cart and create an order.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function checkout(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to checkout.');
        }

        $cart = Cart::get();
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Cart is empty!');
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'total' => Cart::total(),
            'status' => 'pending',
        ]);

        foreach ($cart as $foodId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'food_id' => $foodId,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        Cart::clear();
        return redirect()->route('orders.index')->with('success', 'Order placed successfully!');
    }

    /**
     * Display the user's orders.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to view orders.');
        }

        $orders = Auth::user()->orders()->with('orderItems.food')->get();
        return view(view: 'customer.orders', data: compact('orders'));
    }
}