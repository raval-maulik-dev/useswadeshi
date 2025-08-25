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
            'product_type' => fake()->randomElement(['local', 'foreign']),
            'brand_id' => Brand::factory(),
            'category_id' => Category::factory(),
            'vendor_id' => Vendor::factory(),
            'image_url' => fake()->imageUrl(640, 480, 'products'),
        ];
    }

    /**
     * Indicate that the product is local.
     */
    public function local(): static
    {
        return $this->state(fn (array $attributes) => [
            'product_type' => 'local',
        ]);
    }

    /**
     * Indicate that the product is foreign.
     */
    public function foreign(): static
    {
        return $this->state(fn (array $attributes) => [
            'product_type' => 'foreign',
        ]);
    }
}
