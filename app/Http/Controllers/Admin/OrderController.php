<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Food;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        // Paginate orders to support $orders->links()
        $orders = Order::with('user', 'orderItems.food')->paginate(10);
        return view('admin.order_menu', compact('orders'));
    }

    public function create()
    {
        $foods = Food::all();
        return view('admin.orders.create', compact('foods'));
    }

    public function store(Request $request)
    {
        // Implement if needed for manual order creation by admin
        return redirect()->route('admin.order_menu')->with('success', 'Order created!');
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