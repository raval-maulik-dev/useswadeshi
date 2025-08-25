<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductAlternative>
 */
class ProductAlternativeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'foreign_product_id' => Product::factory()->foreign(),
            'local_product_id' => Product::factory()->local(),
            'note' => fake()->optional()->sentence(),
        ];
    }
}
