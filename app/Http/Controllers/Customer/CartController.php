<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Food;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function viewCart()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('food')->get();
        return view('customer.cart', compact('cartItems'));
    }

    public function addToCart($foodId)
    {
        $food = Food::findOrFail($foodId);
        $cartItem = Cart::where('user_id', Auth::id())->where('food_id', $foodId)->first();

        if ($cartItem) {
            $cartItem->update(['quantity' => $cartItem->quantity + 1]);
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'food_id' => $foodId,
                'quantity' => 1,
            ]);
        }

        return redirect()->route('cart')->with('success', 'Food added to cart!');
    }

    public function updateCart(Request $request, $id)
    {
        $cartItem = Cart::where('user_id', Auth::id())->where('id', $id)->firstOrFail();
        $cartItem->update(['quantity' => $request->quantity]);
        return redirect()->route('cart')->with('success', 'Cart updated!');
    }

    public function removeFromCart($id)
    {
        $cartItem = Cart::where('user_id', Auth::id())->where('id', $id)->firstOrFail();
        $cartItem->delete();
        return redirect()->route('cart')->with('success', 'Item removed from cart!');
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'delivery_address' => 'required|string|max:255',
        ]);

        $cartItems = Cart::where('user_id', Auth::id())->with('food')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }

        $totalAmount = $cartItems->sum(function ($item) {
            return $item->food->price * $item->quantity;
        });

        $order = Order::create([
            'user_id' => Auth::id(),
            'total_amount' => $totalAmount,
            'delivery_address' => $request->delivery_address,
            'status' => 'pending',
            'order_date' => now(),
        ]);

        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id, // Changed from 'orderID' to 'order_id'
                'food_id' => $item->food_id,
                'quantity' => $item->quantity,
                'price' => $item->food->price,
            ]);
        }

        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('order-history')->with('success', 'Order placed successfully!');
    }

    public function orders()
    {
        $orders = Order::where('user_id', Auth::id())->with('orderItems.food')->paginate(10);
        return view('customer.order_history', compact('orders'));
    }

    public function tracker()
    {
        $orders = Order::where('user_id', Auth::id())->with('orderItems.food')->paginate(10);
        return view('customer.tracker', compact('orders'));
    }
}