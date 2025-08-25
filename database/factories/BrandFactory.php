<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->company(),
            'origin_country' => fake()->country(),
        ];
    }

    /**
     * Indicate that the brand is Indian (local).
     */
    public function indian(): static
    {
        return $this->state(fn (array $attributes) => [
            'origin_country' => 'India',
        ]);
    }

    /**
     * Indicate that the brand is foreign.
     */
    public function foreign(): static
    {
        return $this->state(fn (array $attributes) => [
            'origin_country' => fake()->randomElement(['USA', 'China', 'Germany', 'Japan', 'South Korea', 'France', 'Italy', 'UK']),
        ]);
    }
}
