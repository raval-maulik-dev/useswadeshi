<?php

namespace Database\Seeders;

use App\Models\Game;
use Illuminate\Database\Seeder;

class UpdateGamesConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update existing games with new configuration
        $games = Game::all();

        foreach ($games as $game) {
            $game->update([
                'total_questions' => 10, // Default to 10 questions per game
                'per_question_time' => 30, // Default to 30 seconds per question
                'allow_replay' => true,
                'show_correct_answers' => true,
                'is_active' => true,
                'max_attempts' => null, // Unlimited attempts by default
                'certificate_template' => [
                    'title' => 'Certificate of Achievement',
                    'subtitle' => 'Swadeshi Abhiyan',
                    'logo' => 'asset/useswadeshi-remove-bg-logo.png',
                    'signature' => 'Swadeshi Abhiyan Team',
                    'validity' => 'Lifetime',
                ],
            ]);
        }

        $this->command->info('Updated '.$games->count().' games with new configuration fields.');
    }
}
