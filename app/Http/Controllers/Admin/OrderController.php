<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Food;
use App\Models\User;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user', 'orderItems.food')->paginate(10);
        return view('admin.order_menu', compact('orders'));
    }

    public function create()
    {
        $foods = Food::all();
        $customers = User::where('role', 'customer')->get();
        return view('admin.orders.create', compact('foods', 'customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:users,id',
            'items' => 'required|array',
            'items.*.food_id' => 'required|exists:foods,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        // Calculate totals
        $subtotal = 0;
        $deliveryFee = 50;
        $taxRate = 0.1;

        foreach ($request->items as $item) {
            $food = Food::findOrFail($item['food_id']);
            $subtotal += $food->price * $item['quantity'];
        }

        $tax = $subtotal * $taxRate;
        $totalAmount = $subtotal + $deliveryFee + $tax;

        // Create the order
        $order = Order::create([
            'user_id' => $request->customer_id,
            'total_amount' => $totalAmount,
            'status' => 'pending',
        ]);

        // Create order items
        foreach ($request->items as $item) {
            $food = Food::findOrFail($item['food_id']);
            OrderItem::create([
                'order_id' => $order->id,
                'food_id' => $item['food_id'],
                'quantity' => $item['quantity'],
                'price' => $food->price,
            ]);
        }

        return redirect()->route('admin.order_menu')->with('success', 'Order created successfully!');
    }

    public function show(Order $order)
    {
        $order->load('user', 'orderItems.food');
        return view('admin.orders.show', compact('order'));
    }

    public function complete(Order $order)
    {
        $order->status = 'completed';
        $order->save();
        return redirect()->route('admin.order_menu')->with('success', 'Order marked as completed!');
    }

    public function cancel(Order $order)
    {
        $order->status = 'cancelled';
        $order->save();
        return redirect()->route('admin.order_menu')->with('success', 'Order cancelled!');
    }
}