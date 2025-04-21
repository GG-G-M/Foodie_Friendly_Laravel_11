<?php
namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{
    public function run()
    {
        $users = User::where('role', 'customer')->get();
        
        $foodItems = [
            ['name' => 'Pepperoni Pizza', 'category' => 'Pizza', 'price' => 12.99],
            ['name' => 'Cheese Burger', 'category' => 'Burger', 'price' => 8.50],
            ['name' => 'Chicken Wings', 'category' => 'Appetizer', 'price' => 9.75],
            ['name' => 'Caesar Salad', 'category' => 'Salad', 'price' => 7.99],
            ['name' => 'Soda', 'category' => 'Drink', 'price' => 2.50],
        ];
        
        foreach ($users as $user) {
            for ($i = 0; $i < rand(1, 5); $i++) 
                $items = [];
                $total = 0;
                
                // Add 1-3 random items to the order
                for ($j = 0; $j < rand(1, 3); $j++) {
                    $item = $foodItems[array_rand($foodItems)];
                    $quantity = rand(1, 3);
                    $items[] = [
                        'name' => $item['name'],
                        'category' => $item['category'],
                        'price' => $item['price'],
                        'quantity' => $quantity
                    ];
                    $total += $item['price'] * $quantity;
                }
                
                $statuses = ['pending', 'completed', 'cancelled'];
                
                Order::create([
                    'user_id' => $user->id,
                    'total_price' => $total,
                    'status' => $statuses[array_rand($statuses)],
                    'items' => $items
                ]);
            }
        }
    }
}