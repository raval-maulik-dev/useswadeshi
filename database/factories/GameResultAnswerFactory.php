<?php

namespace Database\Factories;

use App\Models\GameOption;
use App\Models\GameResultQuestion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GameResultAnswer>
 */
class GameResultAnswerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'game_result_question_id' => GameResultQuestion::factory(),
            'option_id' => GameOption::factory(),
            'option_text' => fake()->words(2, true),
            'is_correct_option' => fake()->boolean(),
            'selected' => fake()->boolean(),
        ];
    }

    /**
     * Mark the answer as selected by user.
     */
    public function selected(): static
    {
        return $this->state(fn (array $attributes) => [
            'selected' => true,
        ]);
    }

    /**
     * Mark the answer as not selected by user.
     */
    public function notSelected(): static
    {
        return $this->state(fn (array $attributes) => [
            'selected' => false,
        ]);
    }

    /**
     * Mark the answer as correct option.
     */
    public function correct(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_correct_option' => true,
        ]);
    }

    /**
     * Mark the answer as incorrect option.
     */
    public function incorrect(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_correct_option' => false,
        ]);
    }
}
