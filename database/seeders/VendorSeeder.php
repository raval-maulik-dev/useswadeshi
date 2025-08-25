<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create vendors for existing users with vendor role
        $vendorUsers = User::where('role', 'vendor')->get();
        
        foreach ($vendorUsers as $user) {
            Vendor::create([
                'user_id' => $user->id,
                'business_name' => fake()->company(),
                'address' => fake()->address(),
                'phone' => fake()->phoneNumber(),
                'website' => fake()->url(),
                'verified' => true,
            ]);
        }

        // Create additional vendors
        Vendor::factory(15)->create();
    }
}
