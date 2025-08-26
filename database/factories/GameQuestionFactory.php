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
        $types = ['mcq', 'multi_select', 'true_false'];
        $difficulties = ['easy', 'medium', 'hard'];

        return [
            'game_id' => Game::factory(),
            'question' => fake()->sentence().' Is this a Swadeshi product?',
            'type' => fake()->randomElement($types),
            'difficulty' => fake()->randomElement($difficulties),
            'points' => fake()->randomElement([5, 10, 15, 20]),
        ];
    }

    /**
     * Create a multiple choice question.
     */
    public function mcq(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'mcq',
            'question' => fake()->sentence().' Which of the following is a Swadeshi brand?',
        ]);
    }

    /**
     * Create a multi-select question.
     */
    public function multiSelect(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'multi_select',
            'question' => fake()->sentence().' Select all Swadeshi brands from the following:',
        ]);
    }

    /**
     * Create a true/false question.
     */
    public function trueFalse(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'true_false',
            'question' => fake()->sentence().' Is this statement true or false?',
        ]);
    }

    /**
     * Create an easy difficulty question.
     */
    public function easy(): static
    {
        return $this->state(fn (array $attributes) => [
            'difficulty' => 'easy',
            'points' => 5,
        ]);
    }

    /**
     * Create a medium difficulty question.
     */
    public function medium(): static
    {
        return $this->state(fn (array $attributes) => [
            'difficulty' => 'medium',
            'points' => 10,
        ]);
    }

    /**
     * Create a hard difficulty question.
     */
    public function hard(): static
    {
        return $this->state(fn (array $attributes) => [
            'difficulty' => 'hard',
            'points' => 20,
        ]);
    }
}
