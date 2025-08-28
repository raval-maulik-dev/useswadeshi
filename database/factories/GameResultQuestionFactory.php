<?php

namespace Database\Factories;

use App\Models\GameQuestion;
use App\Models\GameResult;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GameResultQuestion>
 */
class GameResultQuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'game_result_id' => GameResult::factory(),
            'question_id' => GameQuestion::factory(),
            'question_text' => fake()->sentence().'?',
            'points' => fake()->numberBetween(1, 20),
            'is_correct' => fake()->boolean(),
            'earned_points' => fake()->numberBetween(0, 20),
            'time_taken' => fake()->numberBetween(1, 60),
        ];
    }

    /**
     * Mark the question as correct.
     */
    public function correct(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_correct' => true,
            'earned_points' => $attributes['points'] ?? 10,
        ]);
    }

    /**
     * Mark the question as incorrect.
     */
    public function incorrect(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_correct' => false,
            'earned_points' => 0,
        ]);
    }
}
