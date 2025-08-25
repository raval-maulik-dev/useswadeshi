<?php

namespace Database\Factories;

use App\Models\Country;
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
            'name' => fake()->company(),
            'description' => fake()->sentence(),
            'logo' => fake()->imageUrl(100, 100, 'business'),
            'country_id' => Country::inRandomOrder()->first()?->id,
        ];
    }

    /**
     * Indicate that the brand is Indian.
     */
    public function indian(): static
    {
        return $this->state(fn (array $attributes) => [
            'description' => 'Leading Indian brand in their respective industry',
            'country_id' => Country::where('code', 'IN')->first()?->id,
        ]);
    }

    /**
     * Indicate that the brand is foreign.
     */
    public function foreign(): static
    {
        return $this->state(fn (array $attributes) => [
            'description' => 'International brand from '.fake()->randomElement(['USA', 'China', 'Germany', 'Japan', 'South Korea', 'France', 'Italy', 'UK']),
            'country_id' => Country::whereNot('code', 'IN')->inRandomOrder()->first()?->id,
        ]);
    }
}
