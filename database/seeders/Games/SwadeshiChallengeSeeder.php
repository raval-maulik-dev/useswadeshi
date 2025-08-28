<?php

namespace Database\Seeders\Games;

use App\Models\Brand;
use App\Models\Game;
use App\Models\GameOption;
use App\Models\GameQuestion;
use App\Models\Product;
use Illuminate\Database\Seeder;

class SwadeshiChallengeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $game = Game::firstOrCreate(
            ['name' => 'Swadeshi Challenge'],
            ['description' => 'Test your knowledge about Indian products vs foreign products']
        );

        $this->createBasicBrandQuestions($game);
        $this->createProductOriginQuestions($game);
        $this->createIndustrySpecificQuestions($game);
        $this->createHistoricalQuestions($game);
        $this->createAwarenessQuestions($game);
    }

    /**
     * Create basic brand identification questions.
     */
    private function createBasicBrandQuestions(Game $game): void
    {
        $questions = [
            [
                'question' => 'Which of these is an Indian automobile brand?',
                'type' => 'mcq',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'Tata Motors', 'correct' => true],
                    ['text' => 'Toyota', 'correct' => false],
                    ['text' => 'Honda', 'correct' => false],
                    ['text' => 'Ford', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian dairy brands:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Amul', 'correct' => true],
                    ['text' => 'Mother Dairy', 'correct' => true],
                    ['text' => 'Nestle', 'correct' => false],
                    ['text' => 'Britannia', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Reliance Industries an Indian company?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 5,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which Indian brand is known for "Taste the Thunder"?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'Thums Up', 'correct' => true],
                    ['text' => 'Coca-Cola', 'correct' => false],
                    ['text' => 'Pepsi', 'correct' => false],
                    ['text' => 'Sprite', 'correct' => false],
                ],
            ],
            [
                'question' => 'Identify the Indian IT company:',
                'type' => 'mcq',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'TCS', 'correct' => true],
                    ['text' => 'IBM', 'correct' => false],
                    ['text' => 'Microsoft', 'correct' => false],
                    ['text' => 'Oracle', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which of these are Indian pharmaceutical companies?',
                'type' => 'multi_select',
                'difficulty' => 'hard',
                'points' => 20,
                'options' => [
                    ['text' => 'Sun Pharmaceutical', 'correct' => true],
                    ['text' => 'Dr. Reddy\'s', 'correct' => true],
                    ['text' => 'Pfizer', 'correct' => false],
                    ['text' => 'Cipla', 'correct' => true],
                ],
            ],
            [
                'question' => 'Is Mahindra & Mahindra an Indian company?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 5,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which Indian brand owns Jio?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'Reliance', 'correct' => true],
                    ['text' => 'Airtel', 'correct' => false],
                    ['text' => 'Vodafone', 'correct' => false],
                    ['text' => 'BSNL', 'correct' => false],
                ],
            ],
        ];

        foreach ($questions as $questionData) {
            $this->createQuestion($game, $questionData);
        }
    }

    /**
     * Create product origin and manufacturing questions.
     */
    private function createProductOriginQuestions(Game $game): void
    {
        $questions = [
            [
                'question' => 'Which product is made in India?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Maruti Swift', 'correct' => true],
                    ['text' => 'iPhone', 'correct' => false],
                    ['text' => 'Samsung Galaxy', 'correct' => false],
                    ['text' => 'Toyota Camry', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select products that have strong Indian alternatives:',
                'type' => 'multi_select',
                'difficulty' => 'hard',
                'points' => 20,
                'options' => [
                    ['text' => 'Amul Butter vs Foreign Butter', 'correct' => true],
                    ['text' => 'Tata Tea vs Lipton', 'correct' => true],
                    ['text' => 'iPhone vs Indian Smartphones', 'correct' => true],
                    ['text' => 'Nike Shoes vs Indian Footwear', 'correct' => true],
                ],
            ],
            [
                'question' => 'Is the Tata Nano an Indian car?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 5,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which Indian company manufactures the Scorpio SUV?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'Mahindra', 'correct' => true],
                    ['text' => 'Tata', 'correct' => false],
                    ['text' => 'Maruti', 'correct' => false],
                    ['text' => 'Honda', 'correct' => false],
                ],
            ],
            [
                'question' => 'Identify Indian textile brands:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Raymond', 'correct' => true],
                    ['text' => 'Arvind Mills', 'correct' => true],
                    ['text' => 'Zara', 'correct' => false],
                    ['text' => 'H&M', 'correct' => false],
                ],
            ],
        ];

        foreach ($questions as $questionData) {
            $this->createQuestion($game, $questionData);
        }
    }

    /**
     * Create industry-specific questions.
     */
    private function createIndustrySpecificQuestions(Game $game): void
    {
        $questions = [
            [
                'question' => 'Which Indian company is a leader in steel production?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'Tata Steel', 'correct' => true],
                    ['text' => 'JSW Steel', 'correct' => true],
                    ['text' => 'ArcelorMittal', 'correct' => false],
                    ['text' => 'POSCO', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select Indian banking institutions:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'State Bank of India', 'correct' => true],
                    ['text' => 'HDFC Bank', 'correct' => true],
                    ['text' => 'ICICI Bank', 'correct' => true],
                    ['text' => 'Citibank', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Infosys an Indian IT company?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 5,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which Indian company owns the "Dabur" brand?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'Dabur India Ltd', 'correct' => true],
                    ['text' => 'Hindustan Unilever', 'correct' => false],
                    ['text' => 'P&G', 'correct' => false],
                    ['text' => 'Colgate-Palmolive', 'correct' => false],
                ],
            ],
            [
                'question' => 'Identify Indian FMCG companies:',
                'type' => 'multi_select',
                'difficulty' => 'hard',
                'points' => 20,
                'options' => [
                    ['text' => 'Hindustan Unilever', 'correct' => true],
                    ['text' => 'ITC Limited', 'correct' => true],
                    ['text' => 'Marico', 'correct' => true],
                    ['text' => 'Nestle India', 'correct' => false],
                ],
            ],
        ];

        foreach ($questions as $questionData) {
            $this->createQuestion($game, $questionData);
        }
    }

    /**
     * Create historical and legacy questions.
     */
    private function createHistoricalQuestions(Game $game): void
    {
        $questions = [
            [
                'question' => 'Which Indian company was founded by Jamsetji Tata?',
                'type' => 'mcq',
                'difficulty' => 'hard',
                'points' => 15,
                'options' => [
                    ['text' => 'Tata Group', 'correct' => true],
                    ['text' => 'Reliance', 'correct' => false],
                    ['text' => 'Birla Group', 'correct' => false],
                    ['text' => 'Mahindra Group', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select companies founded before Indian independence:',
                'type' => 'multi_select',
                'difficulty' => 'hard',
                'points' => 20,
                'options' => [
                    ['text' => 'Tata Group (1868)', 'correct' => true],
                    ['text' => 'Godrej (1897)', 'correct' => true],
                    ['text' => 'Reliance (1966)', 'correct' => false],
                    ['text' => 'Mahindra (1945)', 'correct' => true],
                ],
            ],
            [
                'question' => 'Was Amul founded as a cooperative movement?',
                'type' => 'true_false',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which Indian company pioneered the "White Revolution"?',
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
        ];

        foreach ($questions as $questionData) {
            $this->createQuestion($game, $questionData);
        }
    }

    /**
     * Create awareness and impact questions.
     */
    private function createAwarenessQuestions(Game $game): void
    {
        $questions = [
            [
                'question' => 'What percentage of India\'s GDP comes from MSMEs?',
                'type' => 'mcq',
                'difficulty' => 'hard',
                'points' => 15,
                'options' => [
                    ['text' => 'Around 30%', 'correct' => true],
                    ['text' => 'Around 10%', 'correct' => false],
                    ['text' => 'Around 50%', 'correct' => false],
                    ['text' => 'Around 70%', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select benefits of buying local products:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Supports local economy', 'correct' => true],
                    ['text' => 'Reduces carbon footprint', 'correct' => true],
                    ['text' => 'Creates local jobs', 'correct' => true],
                    ['text' => 'Preserves cultural heritage', 'correct' => true],
                ],
            ],
            [
                'question' => 'Is "Make in India" a government initiative?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 5,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which sector contributes most to India\'s employment?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'Agriculture', 'correct' => true],
                    ['text' => 'IT Services', 'correct' => false],
                    ['text' => 'Manufacturing', 'correct' => false],
                    ['text' => 'Banking', 'correct' => false],
                ],
            ],
            [
                'question' => 'Identify Indian startup success stories:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Paytm', 'correct' => true],
                    ['text' => 'Ola', 'correct' => true],
                    ['text' => 'Flipkart', 'correct' => true],
                    ['text' => 'Uber', 'correct' => false],
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
