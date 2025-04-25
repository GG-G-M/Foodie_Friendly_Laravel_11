<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Food;

class FoodSeeder extends Seeder
{
    public function run()
    {
        Food::create([
            'name' => 'Whole Pizza',
            'description' => 'Delicious 12" pizza',
            'price' => 499,
            'image' => 'pizza.jpg',
        ]);

        Food::create([
            'name' => 'BSK Burger',
            'description' => 'Juicy beef burger',
            'price' => 199,
            'image' => 'burger.jpg',
        ]);
        $this->command->info('Food created successfully!');
    }
}