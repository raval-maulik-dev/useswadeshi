<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\GameQuestion;
use Illuminate\Database\Seeder;

class GameQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create questions for existing games
        $games = Game::all();

        foreach ($games as $game) {
            // Create 5-10 questions per game
            $questionCount = rand(5, 10);

            for ($i = 0; $i < $questionCount; $i++) {
                $isSwadeshi = fake()->boolean(70); // 70% chance of being swadeshi

                GameQuestion::create([
                    'game_id' => $game->id,
                    'question' => fake()->sentence().' Is this a Swadeshi product?',
                    'options' => ['Yes', 'No'],
                    'correct_answer' => $isSwadeshi ? 'Yes' : 'No',
                ]);
            }
        }

        // Create additional random questions
        GameQuestion::factory(30)->create();
    }
}
