<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Food;

class FoodSeeder extends Seeder
{
    public function run()
    {
        $foods = [
            [
                'name' => 'Margherita Pizza',
                'category' => 'Pizza',
                'price' => 9.99
            ],
            [
                'name' => 'Pepperoni Pizza',
                'category' => 'Pizza',
                'price' => 11.99
            ],
            [
                'name' => 'Chicken Burger',
                'category' => 'Burger',
                'price' => 7.99
            ],
            [
                'name' => 'Cheeseburger',
                'category' => 'Burger',
                'price' => 6.99
            ],
            [
                'name' => 'Caesar Salad',
                'category' => 'Salad',
                'price' => 8.49
            ],
            [
                'name' => 'French Fries',
                'category' => 'Side',
                'price' => 3.99
            ],
            [
                'name' => 'Coca-Cola',
                'category' => 'Drink',
                'price' => 2.49
            ]
        ];

        foreach ($foods as $food) {
            Food::firstOrCreate(
                ['name' => $food['name']],
                $food
            );
        }

        $this->command->info('Sample food items seeded successfully!');
    }
}