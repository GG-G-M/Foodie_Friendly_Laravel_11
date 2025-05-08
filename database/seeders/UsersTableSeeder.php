<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $customers = [
            [
                'name' => 'Customer One',
                'email' => 'customer1@gmail.com',
                'password' => Hash::make('123'),
                'role' => 'customer',
            ],
            [
                'name' => 'Customer Two',
                'email' => 'customer2@gmail.com',
                'password' => Hash::make('123'),
                'role' => 'customer',
            ],
            [
                'name' => 'Customer Three',
                'email' => 'customer3@gmail.com',
                'password' => Hash::make('123'),
                'role' => 'customer',
            ],
            [
                'name' => 'Customer Four',
                'email' => 'customer4@gmail.com',
                'password' => Hash::make('123'),
                'role' => 'customer',
            ],
            [
                'name' => 'Customer Five',
                'email' => 'customer5@gmail.com',
                'password' => Hash::make('123'),
                'role' => 'customer',
            ],
            [
                'name' => 'Customer Six',
                'email' => 'customer6@gmail.com',
                'password' => Hash::make('123'),
                'role' => 'customer',
            ],
        ];

        foreach ($customers as $customer) {
            User::firstOrCreate(
                ['email' => $customer['email']],
                [
                    'name' => $customer['name'],
                    'password' => $customer['password'],
                    'role' => $customer['role'],
                    'email_verified_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        $this->command->info('User seeded successfully!');
    }
}