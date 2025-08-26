<?php

namespace Database\Seeders;

use App\Models\Pledge;
use App\Models\User;
use Illuminate\Database\Seeder;

class PledgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create pledges for existing users
        $users = User::where('role', 'user')->get();

        foreach ($users as $user) {
            // Create 1-3 pledges per user
            $pledgeCount = rand(1, 3);

            for ($i = 0; $i < $pledgeCount; $i++) {
                Pledge::create([
                    'user_id' => $user->id,
                    'pledge_text' => fake()->paragraph(),
                    'status' => fake()->randomElement(['pending', 'approved', 'rejected']),
                    'admin_notes' => fake()->optional()->paragraph(),
                ]);
            }
        }

        // Create additional random pledges
        // Pledge::factory(20)->create();
    }
}
