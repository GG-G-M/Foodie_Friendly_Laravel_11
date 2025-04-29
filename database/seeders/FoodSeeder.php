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
                'name' => 'Pepperoni Pizza',
                'description' => 'A classic pizza topped with pepperoni, mozzarella, and tomato sauce.',
                'price' => 15.99,
                'category' => 'Pizza',
                'image' => 'https://picsum.photos/200/200?random=1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cheese Pizza',
                'description' => 'Simple pizza with a generous layer of melted mozzarella cheese.',
                'price' => 12.50,
                'category' => 'Pizza',
                'image' => 'https://picsum.photos/200/200?random=2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Classic Burger',
                'description' => 'Juicy beef patty with lettuce, tomato, and a sesame seed bun.',
                'price' => 8.99,
                'category' => 'Burger',
                'image' => 'https://picsum.photos/200/200?random=3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Chicken Burger',
                'description' => 'Grilled chicken breast with mayo, lettuce, and pickles.',
                'price' => 9.50,
                'category' => 'Burger',
                'image' => 'https://picsum.photos/200/200?random=4',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cola Drink',
                'description' => 'Refreshing cola served ice-cold.',
                'price' => 2.50,
                'category' => 'Drink',
                'image' => 'https://picsum.photos/200/200?random=5',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Lemonade',
                'description' => 'Freshly squeezed lemonade with a hint of mint.',
                'price' => 3.00,
                'category' => 'Drink',
                'image' => 'https://picsum.photos/200/200?random=6',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Food::insert($foods);
        $this->command->info('Food database seeded successfully!');
    }
}