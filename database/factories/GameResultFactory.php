<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GameResult>
 */
class GameResultFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $totalQuestions = fake()->numberBetween(5, 20);
        $score = fake()->numberBetween(0, $totalQuestions);
        
        return [
            'user_id' => User::factory(),
            'game_id' => Game::factory(),
            'score' => $score,
            'total_questions' => $totalQuestions,
            'result_summary' => [
                'correct_answers' => $score,
                'incorrect_answers' => $totalQuestions - $score,
                'percentage' => round(($score / $totalQuestions) * 100, 2),
                'time_taken' => fake()->numberBetween(30, 300), // seconds
            ],
        ];
    }

    /**
     * Indicate that the result is a perfect score.
     */
    public function perfect(): static
    {
        return $this->state(fn (array $attributes) => [
            'score' => $attributes['total_questions'],
            'result_summary' => [
                'correct_answers' => $attributes['total_questions'],
                'incorrect_answers' => 0,
                'percentage' => 100,
                'time_taken' => fake()->numberBetween(30, 300),
            ],
        ]);
    }
}
