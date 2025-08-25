<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vendor;
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
                'name' => fake()->company(),
                'description' => fake()->sentence(),
                'logo' => fake()->imageUrl(100, 100, 'business'),
                'website' => fake()->url(),
                'contact_email' => fake()->email(),
                'contact_phone' => fake()->phoneNumber(),
            ]);
        }

        // Create additional vendors
        Vendor::factory(15)->create();
    }
}
