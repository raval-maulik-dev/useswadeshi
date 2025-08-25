<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'maulik.raval@bacancy.com',
            'phone' => '+91-9876543210',
            'role' => 'admin',
            'password' => Hash::make('Reset@123'),
            'email_verified_at' => now(),
        ]);

        // Create vendor user
        User::create([
            'name' => 'Vendor User',
            'email' => 'vendor@useswadeshi.com',
            'phone' => '+91-9876543211',
            'role' => 'vendor',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Create regular user
        User::create([
            'name' => 'Regular User',
            'email' => 'user@useswadeshi.com',
            'phone' => '+91-9876543212',
            'role' => 'user',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Create additional users
        //        User::factory(10)->create();
    }
}
