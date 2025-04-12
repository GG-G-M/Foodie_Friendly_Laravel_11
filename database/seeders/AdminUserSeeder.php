<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user if doesn't exist
        User::firstOrCreate(
            ['email' => 'admin@foodiefriendly.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('adminpassword'), // Change this to a secure password
                'role' => 'admin'
            ]
        );

        User::firstOrCreate(
            ['email' => 'gilgregenemantilla@gmail.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('123'), // Change this to a secure password
                'role' => 'admin'
            ]
        );


        // Create sample customer users for testing
        User::factory()->count(5)->create([
            'role' => 'customer'
        ]);

        $this->command->info('Admin user created successfully!');
    }
}