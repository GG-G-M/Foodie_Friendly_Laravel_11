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
    public function index()
    {
        $foods = Food::all();
        return view('customer.index', compact('foods'));
    }

    public function viewCart()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('food')->get();
        $total = $cartItems->sum(function ($item) {
            return $item->food->price * $item->quantity;
        });
        return view('customer.cart', compact('cartItems', 'total'));
    }

    public function addToCart(Request $request, $foodId)
    {
        $food = Food::findOrFail($foodId);
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = Cart::where('user_id', Auth::id())->where('food_id', $foodId)->first();

        if ($cartItem) {
            $cartItem->update(['quantity' => $cartItem->quantity + $validated['quantity']]);
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'food_id' => $foodId,
                'quantity' => $validated['quantity'],
            ]);
        }

        return redirect()->route('home')->with('success', 'Food added to cart!');
    }

    public function updateCart(Request $request, $id)
    {
        $cartItem = Cart::where('user_id', Auth::id())->where('id', $id)->firstOrFail();
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem->update(['quantity' => $validated['quantity']]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'quantity' => $cartItem->quantity,
            ]);
        }

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
        $validated = $request->validate([
            'delivery_address' => 'required|string|max:255',
            'payment_method' => 'required|string|in:Cash on Delivery,GCash,PayMaya',
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
            'delivery_address' => $validated['delivery_address'],
            'status' => 'pending',
            'payment_status' => 'pending',
            'payment_method' => $validated['payment_method'],
            'order_date' => now(),
        ]);

        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
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
        $orders = Order::where('user_id', Auth::id())
            ->with('orderItems.food', 'rider.user') // Eager load rider and rider's user
            ->latest()
            ->paginate(10);
        return view('customer.order-history', compact('orders'));
    }

    public function viewOrder($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->with('orderItems.food', 'rider.user') // Eager load rider and rider's user
            ->firstOrFail();
        return view('customer.order-details', compact('order'));
    }

    public function cancelOrder($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($order->status !== 'pending') {
            return redirect()->route('order.view', $order->id)
                ->with('error', 'Order cannot be canceled because it is already ' . ucfirst($order->status) . '.');
        }

        $order->update([
            'status' => 'cancelled',
        ]);

        return redirect()->route('order.view', $order->id)
            ->with('success', 'Order canceled successfully!');
    }

    public function getOrderStatus($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->with('rider.user') // Eager load rider and rider's user
            ->firstOrFail();

        return response()->json([
            'status' => $order->status,
            'rider' => $order->rider ? [
                'name' => $order->rider->user->name ?? 'Not assigned',
                'phone' => $order->rider->phone_number ?? 'N/A',
            ] : null,
        ]);
    }
}