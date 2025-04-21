<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Food;
use Illuminate\Http\Request;
class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.order_menu', compact('orders'));
    }

    public function show(Order $order)
    {
        return view('admin.order_details', compact('order'));
    }

    public function cancel(Order $order)
    {
        $order->update(['status' => Order::STATUS_CANCELLED]);
        
        return redirect()->route('admin.order_menu')
            ->with('success', 'Order cancelled successfully');
    }

    public function complete(Order $order)
    {
        $order->update(['status' => Order::STATUS_COMPLETED]);
        
        return redirect()->route('admin.order_menu')
            ->with('success', 'Order marked as completed');
    }
    
    //Show the form to create a new order for a customer
    public function create() 
    {
        $customers = User::where('role', 'customer')->get();
        $foodItems = Food::all();
        
        return view('admin.orders.create', compact('customers', 'foodItems'));
    }

    // Store a new order
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:users,id',
            'items' => 'required|array',
            'items.*.food_id' => 'required|exists:foods,id',
            'items.*.quantity' => 'required|integer|min:1'
        ]);

        try {
            $items = [];
            $total = 0;
            
            foreach ($request->items as $itemData) {
                $food = Food::find($itemData['food_id']);
                $quantity = $itemData['quantity'];
                
                $items[] = [
                    'name' => $food->name,
                    'category' => $food->category,
                    'price' => $food->price,
                    'quantity' => $quantity
                ];
                
                $total += $food->price * $quantity;
            }

            $order = Order::create([
                'user_id' => $request->customer_id,
                'total_price' => $total,
                'status' => 'pending',
                'items' => $items
            ]);

            return redirect()->route('admin.order_menu')
                ->with('success', 'Order created successfully!');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Error creating order: ' . $e->getMessage());
        }
    }


}