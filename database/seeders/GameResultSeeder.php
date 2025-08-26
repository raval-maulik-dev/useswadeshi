<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\GameResult;
use App\Models\User;
use Illuminate\Database\Seeder;

class GameResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create results for existing users and games
        $users = User::all();
        $games = Game::all();

        foreach ($users as $user) {
            // Create 1-5 results per user
            $resultCount = rand(1, 5);
            $randomGames = $games->random($resultCount);

            foreach ($randomGames as $game) {
                $totalQuestions = rand(5, 20);
                $score = rand(0, $totalQuestions);

                GameResult::create([
                    'user_id' => $user->id,
                    'game_id' => $game->id,
                    'score' => $score,
                    'total_questions' => $totalQuestions,
                    'answers' => [
                        'correct_answers' => $score,
                        'incorrect_answers' => $totalQuestions - $score,
                        'percentage' => round(($score / $totalQuestions) * 100, 2),
                        'time_taken' => rand(30, 300), // seconds
                    ],
                ]);
            }
        }

        // Create additional random results
        // GameResult::factory(50)->create();
    }
}
