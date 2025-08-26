<?php

namespace Database\Factories;

use App\Models\Game;
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
            'question' => fake()->sentence().' Is this a Swadeshi product?',
            'options' => ['Yes', 'No'],
            'correct_answer' => fake()->randomElement(['Yes', 'No']),
        ];
    }

    /**
     * Indicate that the correct answer is Yes (Swadeshi).
     */
    public function swadeshiAnswer(): static
    {
        return $this->state(fn (array $attributes) => [
            'correct_answer' => 'Yes',
        ]);
    }

    /**
     * Indicate that the correct answer is No (Foreign).
     */
    public function foreignAnswer(): static
    {
        return $this->state(fn (array $attributes) => [
            'correct_answer' => 'No',
        ]);
    }
}
