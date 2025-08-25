<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'description' => fake()->paragraph(),
            'price' => fake()->randomFloat(2, 10, 1000),
            'image' => fake()->imageUrl(400, 300, 'products'),
            'brand_id' => Brand::factory(),
            'category_id' => Category::factory(),
            'vendor_id' => Vendor::factory(),
            'is_swadeshi' => fake()->boolean(70), // 70% chance of being swadeshi
        ];
    }

    /**
     * Indicate that the product is swadeshi (local).
     */
    public function swadeshi(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_swadeshi' => true,
        ]);
    }

    /**
     * Indicate that the product is foreign.
     */
    public function foreign(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_swadeshi' => false,
        ]);
    }
}
