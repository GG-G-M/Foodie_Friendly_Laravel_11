<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use App\Models\Food;
use App\Models\OrderItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    public function run()
    {
        // Get all customers
        $customers = User::where('role', 'customer')->get();

        // Sample food items (assuming a foods table exists)
        $foods = [
            ['name' => 'Pizza', 'price' => 10.00],
            ['name' => 'Burger', 'price' => 5.00],
            ['name' => 'Fries', 'price' => 3.00],
            ['name' => 'Soda', 'price' => 2.00],
        ];

        // Seed the foods table if not already seeded
        foreach ($foods as $food) {
            Food::firstOrCreate(
                ['name' => $food['name']],
                ['price' => $food['price']]
            );
        }

        // Sample delivery addresses
        $deliveryAddresses = [
            '123 Main St',
            '456 Oak Ave',
            '789 Pine Rd',
            '101 Elm St',
        ];

        // Generate orders for each customer
        foreach ($customers as $customer) {
            for ($i = 0; $i < rand(1, 3); $i++) {
                $totalAmount = 0;
                $orderItems = [];

                // Generate random order items
                $itemCount = rand(1, 3);
                for ($j = 0; $j < $itemCount; $j++) {
                    $food = Food::inRandomOrder()->first();
                    $quantity = rand(1, 3);
                    $totalAmount += $food->price * $quantity;
                    $orderItems[] = [
                        'food_id' => $food->id,
                        'quantity' => $quantity,
                        'price' => $food->price,
                    ];
                }

                // Delivery fee and tax
                $deliveryFee = 50;
                $tax = $totalAmount * 0.1;
                $fullAmount = $totalAmount + $deliveryFee + $tax;

                // Create order
                $order = Order::create([
                    'user_id' => $customer->id,
                    'total_amount' => $fullAmount,
                    'delivery_address' => $deliveryAddresses[array_rand($deliveryAddresses)],
                    'payment_method' => $this->randomPaymentMethod(),
                    'payment_status' => $this->randomPaymentStatus(),
                    'order_date' => now(),
                    'status' => 'pending',
                ]);

                // Create order items
                foreach ($orderItems as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'food_id' => $item['food_id'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                    ]);
                }
            }
        }

        $this->command->info('Orders seeded successfully!');
    }

    private function randomPaymentMethod()
    {
        $methods = ['Cash on Delivery', 'Gcash', 'PayMaya'];
        return $methods[array_rand($methods)];
    }

    private function randomPaymentStatus()
    {
        $statuses = ['pending', 'paid'];
        return $statuses[array_rand($statuses)];
    }
}