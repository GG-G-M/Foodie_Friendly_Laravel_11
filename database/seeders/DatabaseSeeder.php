<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Uncomment below if you want to generate random users
        // User::factory(10)->create();

        User::firstOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User']
        );
        
        User::firstOrCreate(
            ['email' => 'customer@gmail.com'],
            [
                'name' => 'Customer',
                'password' => Hash::make('123'),
                'role' => 'customer',
            ]
        );
        
        User::firstOrCreate(
            ['email' => 'gilgregenemantilla@gmail.com'],
            [
                'name' => 'Gilgre',
                'password' => Hash::make('123'),
                'role' => 'admin',
            ]
        );
        

        $this->command->info('Default database seeded successfully!');
    }
}
