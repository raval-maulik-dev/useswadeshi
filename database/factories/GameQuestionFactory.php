<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GameQuestion>
 */
class GameQuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'game_id' => Game::factory(),
            'product_id' => Product::factory(),
            'question_text' => fake()->sentence() . ' Is this product local or foreign?',
            'correct_answer' => fake()->randomElement(['local', 'foreign']),
        ];
    }

    /**
     * Indicate that the correct answer is local.
     */
    public function localAnswer(): static
    {
        return $this->state(fn (array $attributes) => [
            'correct_answer' => 'local',
        ]);
    }

    /**
     * Indicate that the correct answer is foreign.
     */
    public function foreignAnswer(): static
    {
        return $this->state(fn (array $attributes) => [
            'correct_answer' => 'foreign',
        ]);
    }
}
