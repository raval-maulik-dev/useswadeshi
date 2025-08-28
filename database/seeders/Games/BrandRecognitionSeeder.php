<?php

namespace Database\Seeders\Games;

use App\Models\Brand;
use App\Models\Game;
use App\Models\GameOption;
use App\Models\GameQuestion;
use Illuminate\Database\Seeder;

class BrandRecognitionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $game = Game::firstOrCreate(
            ['name' => 'Brand Recognition'],
            ['description' => 'Identify whether brands are Indian or foreign']
        );

        $this->createAutomotiveBrandQuestions($game);
        $this->createTechnologyBrandQuestions($game);
        $this->createFMCGBrandQuestions($game);
        $this->createFashionBrandQuestions($game);
        $this->createBankingBrandQuestions($game);
        $this->createFoodBeverageBrandQuestions($game);
        $this->createPharmaceuticalBrandQuestions($game);
        $this->createTelecomBrandQuestions($game);
    }

    /**
     * Create automotive brand questions.
     */
    private function createAutomotiveBrandQuestions(Game $game): void
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
                'question' => 'Select all Indian automotive brands:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Mahindra', 'correct' => true],
                    ['text' => 'Maruti Suzuki', 'correct' => true],
                    ['text' => 'Hyundai', 'correct' => false],
                    ['text' => 'Tata Motors', 'correct' => true],
                ],
            ],
            [
                'question' => 'Is Bajaj Auto an Indian company?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 5,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which Indian company owns the "Scorpio" brand?',
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
                'question' => 'Identify foreign automotive brands:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'BMW', 'correct' => true],
                    ['text' => 'Mercedes-Benz', 'correct' => true],
                    ['text' => 'Audi', 'correct' => true],
                    ['text' => 'Tata Motors', 'correct' => false],
                ],
            ],
        ];

        foreach ($questions as $questionData) {
            $this->createQuestion($game, $questionData);
        }
    }

    /**
     * Create technology brand questions.
     */
    private function createTechnologyBrandQuestions(Game $game): void
    {
        $questions = [
            [
                'question' => 'Which of these is an Indian IT company?',
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
                'question' => 'Select all Indian technology companies:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Infosys', 'correct' => true],
                    ['text' => 'Wipro', 'correct' => true],
                    ['text' => 'HCL', 'correct' => true],
                    ['text' => 'Apple', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Tech Mahindra an Indian company?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 5,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which Indian company is known for "NxtDigital"?',
                'type' => 'mcq',
                'difficulty' => 'hard',
                'points' => 15,
                'options' => [
                    ['text' => 'Tech Mahindra', 'correct' => true],
                    ['text' => 'TCS', 'correct' => false],
                    ['text' => 'Infosys', 'correct' => false],
                    ['text' => 'Wipro', 'correct' => false],
                ],
            ],
            [
                'question' => 'Identify foreign technology brands:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Google', 'correct' => true],
                    ['text' => 'Facebook', 'correct' => true],
                    ['text' => 'Amazon', 'correct' => true],
                    ['text' => 'TCS', 'correct' => false],
                ],
            ],
        ];

        foreach ($questions as $questionData) {
            $this->createQuestion($game, $questionData);
        }
    }

    /**
     * Create FMCG brand questions.
     */
    private function createFMCGBrandQuestions(Game $game): void
    {
        $questions = [
            [
                'question' => 'Which of these is an Indian FMCG brand?',
                'type' => 'mcq',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'Amul', 'correct' => true],
                    ['text' => 'Nestle', 'correct' => false],
                    ['text' => 'P&G', 'correct' => false],
                    ['text' => 'Unilever', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian FMCG companies:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'ITC Limited', 'correct' => true],
                    ['text' => 'Marico', 'correct' => true],
                    ['text' => 'Dabur', 'correct' => true],
                    ['text' => 'Colgate-Palmolive', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Britannia an Indian company?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 5,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which Indian company owns the "Parachute" brand?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'Marico', 'correct' => true],
                    ['text' => 'HUL', 'correct' => false],
                    ['text' => 'P&G', 'correct' => false],
                    ['text' => 'Dabur', 'correct' => false],
                ],
            ],
            [
                'question' => 'Identify foreign FMCG brands:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Coca-Cola', 'correct' => true],
                    ['text' => 'Pepsi', 'correct' => true],
                    ['text' => 'McDonald\'s', 'correct' => true],
                    ['text' => 'Amul', 'correct' => false],
                ],
            ],
        ];

        foreach ($questions as $questionData) {
            $this->createQuestion($game, $questionData);
        }
    }

    /**
     * Create fashion brand questions.
     */
    private function createFashionBrandQuestions(Game $game): void
    {
        $questions = [
            [
                'question' => 'Which of these is an Indian fashion brand?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'Raymond', 'correct' => true],
                    ['text' => 'Zara', 'correct' => false],
                    ['text' => 'H&M', 'correct' => false],
                    ['text' => 'Nike', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian textile companies:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Arvind Mills', 'correct' => true],
                    ['text' => 'Welspun', 'correct' => true],
                    ['text' => 'Bombay Dyeing', 'correct' => true],
                    ['text' => 'Adidas', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Fabindia an Indian company?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 5,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which Indian company owns the "Peter England" brand?',
                'type' => 'mcq',
                'difficulty' => 'hard',
                'points' => 15,
                'options' => [
                    ['text' => 'Aditya Birla Group', 'correct' => true],
                    ['text' => 'Raymond', 'correct' => false],
                    ['text' => 'Arvind Mills', 'correct' => false],
                    ['text' => 'Welspun', 'correct' => false],
                ],
            ],
            [
                'question' => 'Identify foreign fashion brands:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Gucci', 'correct' => true],
                    ['text' => 'Prada', 'correct' => true],
                    ['text' => 'Louis Vuitton', 'correct' => true],
                    ['text' => 'Raymond', 'correct' => false],
                ],
            ],
        ];

        foreach ($questions as $questionData) {
            $this->createQuestion($game, $questionData);
        }
    }

    /**
     * Create banking brand questions.
     */
    private function createBankingBrandQuestions(Game $game): void
    {
        $questions = [
            [
                'question' => 'Which of these is an Indian bank?',
                'type' => 'mcq',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'State Bank of India', 'correct' => true],
                    ['text' => 'Citibank', 'correct' => false],
                    ['text' => 'HSBC', 'correct' => false],
                    ['text' => 'Standard Chartered', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian private banks:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'HDFC Bank', 'correct' => true],
                    ['text' => 'ICICI Bank', 'correct' => true],
                    ['text' => 'Axis Bank', 'correct' => true],
                    ['text' => 'Citibank', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Kotak Mahindra Bank an Indian company?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 5,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which Indian bank is known as "The Banker to Every Indian"?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'State Bank of India', 'correct' => true],
                    ['text' => 'HDFC Bank', 'correct' => false],
                    ['text' => 'ICICI Bank', 'correct' => false],
                    ['text' => 'Axis Bank', 'correct' => false],
                ],
            ],
            [
                'question' => 'Identify foreign banks in India:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Citibank', 'correct' => true],
                    ['text' => 'HSBC', 'correct' => true],
                    ['text' => 'Standard Chartered', 'correct' => true],
                    ['text' => 'HDFC Bank', 'correct' => false],
                ],
            ],
        ];

        foreach ($questions as $questionData) {
            $this->createQuestion($game, $questionData);
        }
    }

    /**
     * Create food and beverage brand questions.
     */
    private function createFoodBeverageBrandQuestions(Game $game): void
    {
        $questions = [
            [
                'question' => 'Which of these is an Indian beverage brand?',
                'type' => 'mcq',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'Thums Up', 'correct' => true],
                    ['text' => 'Coca-Cola', 'correct' => false],
                    ['text' => 'Pepsi', 'correct' => false],
                    ['text' => 'Sprite', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian food companies:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Mother Dairy', 'correct' => true],
                    ['text' => 'Britannia', 'correct' => true],
                    ['text' => 'Parle', 'correct' => true],
                    ['text' => 'Kellogg\'s', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Parle-G an Indian brand?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 5,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which Indian company owns the "Kurkure" brand?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'PepsiCo India', 'correct' => true],
                    ['text' => 'Parle', 'correct' => false],
                    ['text' => 'Britannia', 'correct' => false],
                    ['text' => 'ITC', 'correct' => false],
                ],
            ],
            [
                'question' => 'Identify foreign food brands:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'McDonald\'s', 'correct' => true],
                    ['text' => 'KFC', 'correct' => true],
                    ['text' => 'Pizza Hut', 'correct' => true],
                    ['text' => 'Amul', 'correct' => false],
                ],
            ],
        ];

        foreach ($questions as $questionData) {
            $this->createQuestion($game, $questionData);
        }
    }

    /**
     * Create pharmaceutical brand questions.
     */
    private function createPharmaceuticalBrandQuestions(Game $game): void
    {
        $questions = [
            [
                'question' => 'Which of these is an Indian pharmaceutical company?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'Sun Pharmaceutical', 'correct' => true],
                    ['text' => 'Pfizer', 'correct' => false],
                    ['text' => 'Novartis', 'correct' => false],
                    ['text' => 'Roche', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian pharma companies:',
                'type' => 'multi_select',
                'difficulty' => 'hard',
                'points' => 20,
                'options' => [
                    ['text' => 'Dr. Reddy\'s', 'correct' => true],
                    ['text' => 'Cipla', 'correct' => true],
                    ['text' => 'Lupin', 'correct' => true],
                    ['text' => 'Merck', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Biocon an Indian company?',
                'type' => 'true_false',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which Indian company is known for "Crocin"?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'GSK India', 'correct' => true],
                    ['text' => 'Cipla', 'correct' => false],
                    ['text' => 'Dr. Reddy\'s', 'correct' => false],
                    ['text' => 'Sun Pharma', 'correct' => false],
                ],
            ],
            [
                'question' => 'Identify foreign pharmaceutical brands:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Pfizer', 'correct' => true],
                    ['text' => 'Novartis', 'correct' => true],
                    ['text' => 'Roche', 'correct' => true],
                    ['text' => 'Cipla', 'correct' => false],
                ],
            ],
        ];

        foreach ($questions as $questionData) {
            $this->createQuestion($game, $questionData);
        }
    }

    /**
     * Create telecom brand questions.
     */
    private function createTelecomBrandQuestions(Game $game): void
    {
        $questions = [
            [
                'question' => 'Which of these is an Indian telecom company?',
                'type' => 'mcq',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'Airtel', 'correct' => true],
                    ['text' => 'Vodafone', 'correct' => false],
                    ['text' => 'Idea', 'correct' => true],
                    ['text' => 'Orange', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian telecom operators:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'BSNL', 'correct' => true],
                    ['text' => 'MTNL', 'correct' => true],
                    ['text' => 'Jio', 'correct' => true],
                    ['text' => 'Vodafone', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Jio an Indian telecom brand?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 5,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which Indian company owns the "Jio" brand?',
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
            [
                'question' => 'Identify foreign telecom brands:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Vodafone', 'correct' => true],
                    ['text' => 'Orange', 'correct' => true],
                    ['text' => 'T-Mobile', 'correct' => true],
                    ['text' => 'Airtel', 'correct' => false],
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
