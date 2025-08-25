<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pledge>
 */
class PledgeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'pledge_text' => fake()->paragraph(),
            'status' => fake()->randomElement(['pending', 'approved', 'rejected']),
            'admin_notes' => fake()->optional()->paragraph(),
        ];
    }
}
