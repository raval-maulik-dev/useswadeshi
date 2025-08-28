<?php

namespace Database\Seeders\Games;

use App\Models\Game;
use App\Models\GameOption;
use App\Models\GameQuestion;
use Illuminate\Database\Seeder;

class UsageImpactCalculatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $game = Game::firstOrCreate(
            ['name' => 'Usage Impact Calculator'],
            ['description' => 'Calculate the impact of switching from foreign to local products']
        );

        $this->createEconomicImpactQuestions($game);
        $this->createEnvironmentalImpactQuestions($game);
        $this->createEmploymentImpactQuestions($game);
        $this->createCarbonFootprintQuestions($game);
        $this->createSupplyChainQuestions($game);
        $this->createCostBenefitQuestions($game);
    }

    /**
     * Create economic impact questions.
     */
    private function createEconomicImpactQuestions(Game $game): void
    {
        $questions = [
            [
                'question' => 'What percentage of money spent on local products stays in the local economy?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Around 68%', 'correct' => true],
                    ['text' => 'Around 30%', 'correct' => false],
                    ['text' => 'Around 90%', 'correct' => false],
                    ['text' => 'Around 50%', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select economic benefits of buying local:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Higher tax revenue for local government', 'correct' => true],
                    ['text' => 'Increased local business growth', 'correct' => true],
                    ['text' => 'Reduced import dependency', 'correct' => true],
                    ['text' => 'Lower inflation rates', 'correct' => true],
                ],
            ],
            [
                'question' => 'Does buying local products reduce trade deficit?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 5,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'How much does the Indian economy lose annually due to foreign product imports?',
                'type' => 'mcq',
                'difficulty' => 'hard',
                'points' => 20,
                'options' => [
                    ['text' => 'Over $500 billion', 'correct' => true],
                    ['text' => 'Around $200 billion', 'correct' => false],
                    ['text' => 'Less than $100 billion', 'correct' => false],
                    ['text' => 'Over $1 trillion', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which sectors benefit most from local purchasing?',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Small and medium enterprises', 'correct' => true],
                    ['text' => 'Local artisans and craftsmen', 'correct' => true],
                    ['text' => 'Agricultural sector', 'correct' => true],
                    ['text' => 'Multinational corporations', 'correct' => false],
                ],
            ],
        ];

        foreach ($questions as $questionData) {
            $this->createQuestion($game, $questionData);
        }
    }

    /**
     * Create environmental impact questions.
     */
    private function createEnvironmentalImpactQuestions(Game $game): void
    {
        $questions = [
            [
                'question' => 'How much carbon footprint is reduced by buying local products?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Up to 50% reduction', 'correct' => true],
                    ['text' => 'Up to 20% reduction', 'correct' => false],
                    ['text' => 'Up to 80% reduction', 'correct' => false],
                    ['text' => 'No significant reduction', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select environmental benefits of local products:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Reduced transportation emissions', 'correct' => true],
                    ['text' => 'Less packaging waste', 'correct' => true],
                    ['text' => 'Lower energy consumption', 'correct' => true],
                    ['text' => 'Preserved local ecosystems', 'correct' => true],
                ],
            ],
            [
                'question' => 'Do local products typically use less packaging?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 5,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'What is the average distance local products travel vs imported products?',
                'type' => 'mcq',
                'difficulty' => 'hard',
                'points' => 20,
                'options' => [
                    ['text' => 'Local: 50-100 km, Imported: 5000-15000 km', 'correct' => true],
                    ['text' => 'Local: 200-500 km, Imported: 2000-5000 km', 'correct' => false],
                    ['text' => 'Local: 1000-2000 km, Imported: 10000-20000 km', 'correct' => false],
                    ['text' => 'No significant difference', 'correct' => false],
                ],
            ],
            [
                'question' => 'Identify sustainable practices in local manufacturing:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Use of renewable energy', 'correct' => true],
                    ['text' => 'Water conservation', 'correct' => true],
                    ['text' => 'Waste recycling', 'correct' => true],
                    ['text' => 'Organic farming methods', 'correct' => true],
                ],
            ],
        ];

        foreach ($questions as $questionData) {
            $this->createQuestion($game, $questionData);
        }
    }

    /**
     * Create employment impact questions.
     */
    private function createEmploymentImpactQuestions(Game $game): void
    {
        $questions = [
            [
                'question' => 'How many jobs are created for every $1 million spent on local products?',
                'type' => 'mcq',
                'difficulty' => 'hard',
                'points' => 20,
                'options' => [
                    ['text' => 'Around 10-15 jobs', 'correct' => true],
                    ['text' => 'Around 5-8 jobs', 'correct' => false],
                    ['text' => 'Around 20-25 jobs', 'correct' => false],
                    ['text' => 'Around 2-3 jobs', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select employment benefits of local purchasing:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Higher wages for local workers', 'correct' => true],
                    ['text' => 'Better working conditions', 'correct' => true],
                    ['text' => 'Skill development opportunities', 'correct' => true],
                    ['text' => 'Reduced unemployment rates', 'correct' => true],
                ],
            ],
            [
                'question' => 'Does supporting local businesses create more jobs than buying imported products?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 5,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which sector employs the most people in India?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'Agriculture', 'correct' => true],
                    ['text' => 'Manufacturing', 'correct' => false],
                    ['text' => 'Services', 'correct' => false],
                    ['text' => 'IT', 'correct' => false],
                ],
            ],
            [
                'question' => 'Identify job types created by local businesses:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Artisan and craft jobs', 'correct' => true],
                    ['text' => 'Small-scale manufacturing', 'correct' => true],
                    ['text' => 'Local retail and services', 'correct' => true],
                    ['text' => 'Agricultural processing', 'correct' => true],
                ],
            ],
        ];

        foreach ($questions as $questionData) {
            $this->createQuestion($game, $questionData);
        }
    }

    /**
     * Create carbon footprint questions.
     */
    private function createCarbonFootprintQuestions(Game $game): void
    {
        $questions = [
            [
                'question' => 'What percentage of global CO2 emissions come from transportation?',
                'type' => 'mcq',
                'difficulty' => 'hard',
                'points' => 20,
                'options' => [
                    ['text' => 'Around 25%', 'correct' => true],
                    ['text' => 'Around 10%', 'correct' => false],
                    ['text' => 'Around 40%', 'correct' => false],
                    ['text' => 'Around 15%', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select ways local products reduce carbon footprint:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Shorter transportation distances', 'correct' => true],
                    ['text' => 'Less refrigeration needed', 'correct' => true],
                    ['text' => 'Reduced packaging materials', 'correct' => true],
                    ['text' => 'Local energy production', 'correct' => true],
                ],
            ],
            [
                'question' => 'Is the carbon footprint of imported products higher than local products?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 5,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'How much CO2 is saved by buying local food vs imported food?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Up to 17 times less CO2', 'correct' => true],
                    ['text' => 'Up to 5 times less CO2', 'correct' => false],
                    ['text' => 'Up to 10 times less CO2', 'correct' => false],
                    ['text' => 'No significant difference', 'correct' => false],
                ],
            ],
            [
                'question' => 'Identify carbon-intensive aspects of global supply chains:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Long-distance shipping', 'correct' => true],
                    ['text' => 'Air freight transportation', 'correct' => true],
                    ['text' => 'Cold storage during transit', 'correct' => true],
                    ['text' => 'Multiple handling points', 'correct' => true],
                ],
            ],
        ];

        foreach ($questions as $questionData) {
            $this->createQuestion($game, $questionData);
        }
    }

    /**
     * Create supply chain questions.
     */
    private function createSupplyChainQuestions(Game $game): void
    {
        $questions = [
            [
                'question' => 'How many intermediaries are typically involved in local vs global supply chains?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Local: 1-2, Global: 5-10', 'correct' => true],
                    ['text' => 'Local: 3-4, Global: 8-12', 'correct' => false],
                    ['text' => 'Local: 0-1, Global: 3-5', 'correct' => false],
                    ['text' => 'No significant difference', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select advantages of local supply chains:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Faster delivery times', 'correct' => true],
                    ['text' => 'Lower transportation costs', 'correct' => true],
                    ['text' => 'Better quality control', 'correct' => true],
                    ['text' => 'Reduced risk of disruption', 'correct' => true],
                ],
            ],
            [
                'question' => 'Are local supply chains more resilient to global disruptions?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 5,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'What percentage of products in Indian markets are imported?',
                'type' => 'mcq',
                'difficulty' => 'hard',
                'points' => 20,
                'options' => [
                    ['text' => 'Around 15-20%', 'correct' => true],
                    ['text' => 'Around 5-10%', 'correct' => false],
                    ['text' => 'Around 30-40%', 'correct' => false],
                    ['text' => 'Around 50-60%', 'correct' => false],
                ],
            ],
            [
                'question' => 'Identify risks of global supply chains:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Political instability', 'correct' => true],
                    ['text' => 'Currency fluctuations', 'correct' => true],
                    ['text' => 'Natural disasters', 'correct' => true],
                    ['text' => 'Trade restrictions', 'correct' => true],
                ],
            ],
        ];

        foreach ($questions as $questionData) {
            $this->createQuestion($game, $questionData);
        }
    }

    /**
     * Create cost-benefit questions.
     */
    private function createCostBenefitQuestions(Game $game): void
    {
        $questions = [
            [
                'question' => 'What is the typical price premium for local products vs imported products?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => '0-15% higher', 'correct' => true],
                    ['text' => '20-30% higher', 'correct' => false],
                    ['text' => '5-10% lower', 'correct' => false],
                    ['text' => '30-50% higher', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select long-term benefits of buying local:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Lower healthcare costs', 'correct' => true],
                    ['text' => 'Reduced environmental damage', 'correct' => true],
                    ['text' => 'Stronger local economy', 'correct' => true],
                    ['text' => 'Better community infrastructure', 'correct' => true],
                ],
            ],
            [
                'question' => 'Do local products typically have better quality than imported products?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 5,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'How much money circulates in the local economy when you buy local?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => '3-7 times more than imported products', 'correct' => true],
                    ['text' => '1-2 times more than imported products', 'correct' => false],
                    ['text' => '10-15 times more than imported products', 'correct' => false],
                    ['text' => 'Same amount as imported products', 'correct' => false],
                ],
            ],
            [
                'question' => 'Identify hidden costs of imported products:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Environmental damage', 'correct' => true],
                    ['text' => 'Loss of local jobs', 'correct' => true],
                    ['text' => 'Increased healthcare costs', 'correct' => true],
                    ['text' => 'Infrastructure maintenance', 'correct' => true],
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
