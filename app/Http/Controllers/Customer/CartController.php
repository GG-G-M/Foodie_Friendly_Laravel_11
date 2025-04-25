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
    public function addToCart(Request $request, $foodId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $food = Food::findOrFail($foodId);
        $user = Auth::user();

        $cartItem = Cart::where('user_id', $user->id)
                        ->where('food_id', $foodId)
                        ->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => $user->id,
                'food_id' => $foodId,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->route('cart')->with('success', 'Food added to cart!');
    }

    public function viewCart()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('food')->get();
        return view('customer.cart', compact('cartItems'));
    }

    public function updateCart(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = Cart::where('id', $id)
                        ->where('user_id', Auth::id())
                        ->firstOrFail();
        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return redirect()->route('cart')->with('success', 'Cart updated!');
    }

    public function removeFromCart($id)
    {
        $cartItem = Cart::where('id', $id)
                        ->where('user_id', Auth::id())
                        ->firstOrFail();
        $cartItem->delete();

        return redirect()->route('cart')->with('success', 'Item removed from cart!');
    }

    public function checkout()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('food')->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty!');
        }

        $subtotal = $cartItems->sum(function ($item) {
            return $item->food->price * $item->quantity;
        });
        $deliveryFee = 50;
        $tax = $subtotal * 0.1; // 10% tax
        $totalAmount = $subtotal + $deliveryFee + $tax;

        $order = Order::create([
            'user_id' => Auth::id(),
            'total_amount' => $totalAmount,
            'status' => 'pending',
        ]);

        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'food_id' => $item->food_id,
                'quantity' => $item->quantity,
                'price' => $item->food->price,
            ]);
        }

        // Clear the cart
        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('order-history')->with('success', 'Order placed successfully!');
    }

    public function orders()
    {
        $orders = Order::where('user_id', Auth::id())->with('orderItems.food')->get();
        return view('customer.order-history', compact('orders'));
    }
}