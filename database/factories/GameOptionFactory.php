<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\GameQuestion;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GameOption>
 */
class GameOptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $optionType = fake()->randomElement(['text', 'product', 'brand']);

        $data = [
            'question_id' => GameQuestion::factory(),
            'is_correct' => fake()->boolean(25), // 25% chance of being correct
            'sort_order' => fake()->numberBetween(1, 10),
        ];

        switch ($optionType) {
            case 'text':
                $data['option_text'] = fake()->words(2, true);
                $data['optionable_id'] = null;
                $data['optionable_type'] = null;
                break;
            case 'product':
                $product = Product::inRandomOrder()->first() ?? Product::factory()->create();
                $data['option_text'] = null;
                $data['optionable_id'] = $product->id;
                $data['optionable_type'] = Product::class;
                break;
            case 'brand':
                $brand = Brand::inRandomOrder()->first() ?? Brand::factory()->create();
                $data['option_text'] = null;
                $data['optionable_id'] = $brand->id;
                $data['optionable_type'] = Brand::class;
                break;
        }

        return $data;
    }

    /**
     * Create a text-based option.
     */
    public function text(?string $text = null): static
    {
        return $this->state(fn (array $attributes) => [
            'option_text' => $text ?? fake()->words(2, true),
            'optionable_id' => null,
            'optionable_type' => null,
        ]);
    }

    /**
     * Create a product-based option.
     */
    public function product(?Product $product = null): static
    {
        $product = $product ?? Product::inRandomOrder()->first() ?? Product::factory()->create();

        return $this->state(fn (array $attributes) => [
            'option_text' => null,
            'optionable_id' => $product->id,
            'optionable_type' => Product::class,
        ]);
    }

    /**
     * Create a brand-based option.
     */
    public function brand(?Brand $brand = null): static
    {
        $brand = $brand ?? Brand::inRandomOrder()->first() ?? Brand::factory()->create();

        return $this->state(fn (array $attributes) => [
            'option_text' => null,
            'optionable_id' => $brand->id,
            'optionable_type' => Brand::class,
        ]);
    }

    /**
     * Mark the option as correct.
     */
    public function correct(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_correct' => true,
        ]);
    }

    /**
     * Mark the option as incorrect.
     */
    public function incorrect(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_correct' => false,
        ]);
    }
}
