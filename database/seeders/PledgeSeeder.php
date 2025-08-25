<?php

namespace Database\Seeders;

use App\Models\Pledge;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PledgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create pledges for existing users and products
        $users = User::where('role', 'user')->get();
        $products = Product::all();

        foreach ($users as $user) {
            // Create 1-3 pledges per user
            $pledgeCount = rand(1, 3);
            $randomProducts = $products->random($pledgeCount);

            foreach ($randomProducts as $product) {
                Pledge::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'message' => fake()->paragraph(),
                    'certificate_url' => fake()->optional()->url(),
                ]);
            }
        }

        // Create additional random pledges
        Pledge::factory(20)->create();
    }
}
