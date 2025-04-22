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
                'name' => 'Customer User',
                'email' => 'customer@gmail.com',
                'password' => '123',
                'role' => 'customer',
            ],
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => '123',
                'role' => 'customer',
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane.smith@example.com',
                'password' => '123',
                'role' => 'customer',
            ],
            [
                'name' => 'Michael Johnson',
                'email' => 'michael.j@example.com',
                'password' => '123',
                'role' => 'customer',
            ],
            [
                'name' => 'Emily Williams',
                'email' => 'emily.w@example.com',
                'password' => '123',
                'role' => 'customer',
            ],
            [
                'name' => 'Robert Brown',
                'email' => 'robert.b@example.com',
                'password' => '123',
                'role' => 'customer',
            ],
            [
                'name' => 'Sarah Davis',
                'email' => 'sarah.d@example.com',
                'password' => '123',
                'role' => 'customer',
            ],
            [
                'name' => 'David Miller',
                'email' => 'david.m@example.com',
                'password' => '123',
                'role' => 'customer',
            ],
            [
                'name' => 'Jessica Wilson',
                'email' => 'jessica.w@example.com',
                'password' => '123',
                'role' => 'customer',
            ],
            [
                'name' => 'Thomas Moore',
                'email' => 'thomas.m@example.com',
                'password' => '123',
                'role' => 'customer',
            ],
            [
                'name' => 'Lisa Taylor',
                'email' => 'lisa.t@example.com',
                'password' => '123',
                'role' => 'customer',
            ],
            [
                'name' => 'Daniel Anderson',
                'email' => 'daniel.a@example.com',
                'password' => '123',
                'role' => 'customer',
            ],
            [
                'name' => 'Megan Thomas',
                'email' => 'megan.t@example.com',
                'password' => '123',
                'role' => 'customer',
            ],
            [
                'name' => 'Christopher Lee',
                'email' => 'chris.lee@example.com',
                'password' => '123',
                'role' => 'customer',
            ],
            [
                'name' => 'Amanda Harris',
                'email' => 'amanda.h@example.com',
                'password' => '123',
                'role' => 'customer',
            ],
            [
                'name' => 'Kevin Martin',
                'email' => 'kevin.m@example.com',
                'password' => '123',
                'role' => 'customer',
            ],
        ];

        foreach ($customers as $customer) {
            User::firstOrCreate(
                ['email' => $customer['email']], // Check if email exists
                [
                    'name' => $customer['name'],
                    'password' => Hash::make($customer['password']),
                    'role' => $customer['role'],
                ]
            );
        }

        $this->command->info('Sample food items seeded successfully!');

    }
}