<?php

namespace Database\Seeders\Games;

use App\Models\Game;
use App\Models\GameOption;
use App\Models\GameQuestion;
use Illuminate\Database\Seeder;

class LocalLegendsTriviaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $game = Game::firstOrCreate(
            ['name' => 'Local Legends Trivia'],
            ['description' => 'Test your knowledge about historic Indian brands and founders']
        );

        $this->createFounderQuestions($game);
        $this->createHistoricBrandQuestions($game);
        $this->createMilestoneQuestions($game);
        $this->createInnovationQuestions($game);
        $this->createLegacyQuestions($game);
    }

    /**
     * Create founder-related questions.
     */
    private function createFounderQuestions(Game $game): void
    {
        $questions = [
            [
                'question' => 'Who founded the Tata Group?',
                'type' => 'mcq',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'Jamsetji Tata', 'correct' => true],
                    ['text' => 'Ratan Tata', 'correct' => false],
                    ['text' => 'JRD Tata', 'correct' => false],
                    ['text' => 'Dorabji Tata', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select founders of major Indian companies:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Dhirubhai Ambani - Reliance', 'correct' => true],
                    ['text' => 'Jamsetji Tata - Tata Group', 'correct' => true],
                    ['text' => 'Karsanbhai Patel - Nirma', 'correct' => true],
                    ['text' => 'Steve Jobs - Apple', 'correct' => false],
                ],
            ],
            [
                'question' => 'Was Verghese Kurien the founder of Amul?',
                'type' => 'true_false',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Who is known as the "Milkman of India"?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'Verghese Kurien', 'correct' => true],
                    ['text' => 'Dhirubhai Ambani', 'correct' => false],
                    ['text' => 'Jamsetji Tata', 'correct' => false],
                    ['text' => 'Karsanbhai Patel', 'correct' => false],
                ],
            ],
            [
                'question' => 'Identify Indian business pioneers:',
                'type' => 'multi_select',
                'difficulty' => 'hard',
                'points' => 20,
                'options' => [
                    ['text' => 'Jamsetji Tata - Steel Industry', 'correct' => true],
                    ['text' => 'Verghese Kurien - White Revolution', 'correct' => true],
                    ['text' => 'Dhirubhai Ambani - Petrochemicals', 'correct' => true],
                    ['text' => 'Karsanbhai Patel - FMCG', 'correct' => true],
                ],
            ],
        ];

        foreach ($questions as $questionData) {
            $this->createQuestion($game, $questionData);
        }
    }

    /**
     * Create historic brand questions.
     */
    private function createHistoricBrandQuestions(Game $game): void
    {
        $questions = [
            [
                'question' => 'Which Indian brand was founded in 1868?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'Tata Group', 'correct' => true],
                    ['text' => 'Godrej', 'correct' => false],
                    ['text' => 'Reliance', 'correct' => false],
                    ['text' => 'Mahindra', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select brands founded before Indian independence:',
                'type' => 'multi_select',
                'difficulty' => 'hard',
                'points' => 20,
                'options' => [
                    ['text' => 'Tata Group (1868)', 'correct' => true],
                    ['text' => 'Godrej (1897)', 'correct' => true],
                    ['text' => 'Mahindra (1945)', 'correct' => true],
                    ['text' => 'Reliance (1966)', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Godrej one of India\'s oldest companies?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 5,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which company pioneered the "White Revolution"?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'Amul', 'correct' => true],
                    ['text' => 'Mother Dairy', 'correct' => false],
                    ['text' => 'Britannia', 'correct' => false],
                    ['text' => 'Nestle', 'correct' => false],
                ],
            ],
            [
                'question' => 'Identify historic Indian brands:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Tata Steel', 'correct' => true],
                    ['text' => 'Godrej Soaps', 'correct' => true],
                    ['text' => 'Mahindra Tractors', 'correct' => true],
                    ['text' => 'Reliance Industries', 'correct' => false],
                ],
            ],
        ];

        foreach ($questions as $questionData) {
            $this->createQuestion($game, $questionData);
        }
    }

    /**
     * Create milestone questions.
     */
    private function createMilestoneQuestions(Game $game): void
    {
        $questions = [
            [
                'question' => 'In which year was the first Indian car manufactured?',
                'type' => 'mcq',
                'difficulty' => 'hard',
                'points' => 20,
                'options' => [
                    ['text' => '1942', 'correct' => true],
                    ['text' => '1947', 'correct' => false],
                    ['text' => '1950', 'correct' => false],
                    ['text' => '1960', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select major milestones in Indian business history:',
                'type' => 'multi_select',
                'difficulty' => 'hard',
                'points' => 20,
                'options' => [
                    ['text' => 'First Indian car - Hindustan 10 (1942)', 'correct' => true],
                    ['text' => 'White Revolution - Amul (1970s)', 'correct' => true],
                    ['text' => 'Green Revolution - Agricultural growth', 'correct' => true],
                    ['text' => 'IT Revolution - TCS, Infosys (1980s)', 'correct' => true],
                ],
            ],
            [
                'question' => 'Was the first Indian car manufactured by Hindustan Motors?',
                'type' => 'true_false',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which company launched India\'s first indigenous car?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'Hindustan Motors', 'correct' => true],
                    ['text' => 'Tata Motors', 'correct' => false],
                    ['text' => 'Mahindra', 'correct' => false],
                    ['text' => 'Maruti', 'correct' => false],
                ],
            ],
            [
                'question' => 'Identify revolutionary movements in India:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'White Revolution - Dairy', 'correct' => true],
                    ['text' => 'Green Revolution - Agriculture', 'correct' => true],
                    ['text' => 'Blue Revolution - Fisheries', 'correct' => true],
                    ['text' => 'Digital Revolution - IT', 'correct' => true],
                ],
            ],
        ];

        foreach ($questions as $questionData) {
            $this->createQuestion($game, $questionData);
        }
    }

    /**
     * Create innovation questions.
     */
    private function createInnovationQuestions(Game $game): void
    {
        $questions = [
            [
                'question' => 'Which Indian company developed the world\'s cheapest car?',
                'type' => 'mcq',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'Tata Motors', 'correct' => true],
                    ['text' => 'Mahindra', 'correct' => false],
                    ['text' => 'Maruti', 'correct' => false],
                    ['text' => 'Honda', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select Indian innovations:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Tata Nano - World\'s cheapest car', 'correct' => true],
                    ['text' => 'Amul - Cooperative dairy model', 'correct' => true],
                    ['text' => 'ISRO - Space technology', 'correct' => true],
                    ['text' => 'Aadhaar - Digital identity', 'correct' => true],
                ],
            ],
            [
                'question' => 'Did India develop its own space program?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 5,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which Indian company pioneered the cooperative dairy movement?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'Amul', 'correct' => true],
                    ['text' => 'Mother Dairy', 'correct' => false],
                    ['text' => 'Britannia', 'correct' => false],
                    ['text' => 'Nestle', 'correct' => false],
                ],
            ],
            [
                'question' => 'Identify Indian technological achievements:',
                'type' => 'multi_select',
                'difficulty' => 'hard',
                'points' => 20,
                'options' => [
                    ['text' => 'Mangalyaan - Mars mission', 'correct' => true],
                    ['text' => 'Chandrayaan - Moon mission', 'correct' => true],
                    ['text' => 'Aadhaar - Biometric ID', 'correct' => true],
                    ['text' => 'UPI - Digital payments', 'correct' => true],
                ],
            ],
        ];

        foreach ($questions as $questionData) {
            $this->createQuestion($game, $questionData);
        }
    }

    /**
     * Create legacy questions.
     */
    private function createLegacyQuestions(Game $game): void
    {
        $questions = [
            [
                'question' => 'Which Indian business family is known for philanthropy?',
                'type' => 'mcq',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'Tata Family', 'correct' => true],
                    ['text' => 'Ambani Family', 'correct' => false],
                    ['text' => 'Birla Family', 'correct' => true],
                    ['text' => 'Godrej Family', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select Indian business legacies:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Tata Trusts - Education & Healthcare', 'correct' => true],
                    ['text' => 'Birla Institute - Technical Education', 'correct' => true],
                    ['text' => 'Amul - Rural Development', 'correct' => true],
                    ['text' => 'Reliance Foundation - Social Causes', 'correct' => true],
                ],
            ],
            [
                'question' => 'Do Indian business families contribute to social causes?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 5,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which company\'s founder donated 66% of his wealth to charity?',
                'type' => 'mcq',
                'difficulty' => 'hard',
                'points' => 20,
                'options' => [
                    ['text' => 'Tata Group', 'correct' => true],
                    ['text' => 'Reliance', 'correct' => false],
                    ['text' => 'Mahindra', 'correct' => false],
                    ['text' => 'Godrej', 'correct' => false],
                ],
            ],
            [
                'question' => 'Identify contributions to Indian society:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Tata Institute of Social Sciences', 'correct' => true],
                    ['text' => 'Indian Institute of Science', 'correct' => true],
                    ['text' => 'Tata Memorial Hospital', 'correct' => true],
                    ['text' => 'National Centre for Performing Arts', 'correct' => true],
                ],
            ],
        ];

        foreach ($questions as $questionData) {
            $this->createQuestion($game, $questionData);
        }
    }

    /**
     * Create a question with its options.
     */
    private function createQuestion(Game $game, array $questionData): void
    {
        $question = GameQuestion::firstOrCreate([
            'game_id' => $game->id,
            'question' => $questionData['question'],
        ], [
            'type' => $questionData['type'],
            'difficulty' => $questionData['difficulty'],
            'points' => $questionData['points'],
        ]);

        // Create options for this question
        foreach ($questionData['options'] as $index => $optionData) {
            GameOption::firstOrCreate([
                'question_id' => $question->id,
                'option_text' => $optionData['text'],
            ], [
                'optionable_id' => null,
                'optionable_type' => null,
                'is_correct' => $optionData['correct'],
                'sort_order' => $index + 1,
            ]);
        }
    }
}
