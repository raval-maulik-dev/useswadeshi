<?php

namespace Database\Seeders\Games;

use Illuminate\Database\Seeder;

class GamesMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            SwadeshiChallengeSeeder::class,
            BrandRecognitionSeeder::class,
            UsageImpactCalculatorSeeder::class,
            LocalLegendsTriviaSeeder::class,
        ]);

        // Create additional games with basic questions
        $this->createAdditionalGames();
    }

    /**
     * Create additional games with basic questions.
     */
    private function createAdditionalGames(): void
    {
        $games = [
            [
                'name' => 'Product Origins',
                'description' => 'Learn about the origins of various products',
                'questions' => [
                    [
                        'question' => 'Where was the first iPhone manufactured?',
                        'type' => 'mcq',
                        'difficulty' => 'easy',
                        'points' => 10,
                        'options' => [
                            ['text' => 'China', 'correct' => true],
                            ['text' => 'USA', 'correct' => false],
                            ['text' => 'India', 'correct' => false],
                            ['text' => 'Japan', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Which country produces the most textiles?',
                        'type' => 'mcq',
                        'difficulty' => 'medium',
                        'points' => 15,
                        'options' => [
                            ['text' => 'China', 'correct' => true],
                            ['text' => 'India', 'correct' => false],
                            ['text' => 'USA', 'correct' => false],
                            ['text' => 'Bangladesh', 'correct' => false],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Local vs Global',
                'description' => 'Compare local and global products',
                'questions' => [
                    [
                        'question' => 'Which is typically more expensive: local or imported products?',
                        'type' => 'mcq',
                        'difficulty' => 'easy',
                        'points' => 10,
                        'options' => [
                            ['text' => 'Imported products', 'correct' => true],
                            ['text' => 'Local products', 'correct' => false],
                            ['text' => 'Same price', 'correct' => false],
                            ['text' => 'Depends on the product', 'correct' => true],
                        ],
                    ],
                    [
                        'question' => 'Select advantages of local products:',
                        'type' => 'multi_select',
                        'difficulty' => 'medium',
                        'points' => 15,
                        'options' => [
                            ['text' => 'Fresher ingredients', 'correct' => true],
                            ['text' => 'Lower carbon footprint', 'correct' => true],
                            ['text' => 'Supports local economy', 'correct' => true],
                            ['text' => 'Better quality control', 'correct' => true],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Swadeshi Quiz Marathon',
                'description' => 'Answer a series of timed questions about local businesses and culture',
                'questions' => [
                    [
                        'question' => 'What does "Swadeshi" mean?',
                        'type' => 'mcq',
                        'difficulty' => 'easy',
                        'points' => 10,
                        'options' => [
                            ['text' => 'Of one\'s own country', 'correct' => true],
                            ['text' => 'Foreign goods', 'correct' => false],
                            ['text' => 'Local market', 'correct' => false],
                            ['text' => 'Traditional craft', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Who started the Swadeshi movement?',
                        'type' => 'mcq',
                        'difficulty' => 'medium',
                        'points' => 15,
                        'options' => [
                            ['text' => 'Mahatma Gandhi', 'correct' => true],
                            ['text' => 'Rabindranath Tagore', 'correct' => false],
                            ['text' => 'Subhas Chandra Bose', 'correct' => false],
                            ['text' => 'Jawaharlal Nehru', 'correct' => false],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Festival Special Quiz',
                'description' => 'A limited-time quiz based on Indian festivals and local traditions',
                'questions' => [
                    [
                        'question' => 'Which festival promotes buying local products?',
                        'type' => 'mcq',
                        'difficulty' => 'easy',
                        'points' => 10,
                        'options' => [
                            ['text' => 'Diwali', 'correct' => true],
                            ['text' => 'Holi', 'correct' => false],
                            ['text' => 'Eid', 'correct' => false],
                            ['text' => 'Christmas', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Select traditional Indian festivals:',
                        'type' => 'multi_select',
                        'difficulty' => 'medium',
                        'points' => 15,
                        'options' => [
                            ['text' => 'Diwali', 'correct' => true],
                            ['text' => 'Holi', 'correct' => true],
                            ['text' => 'Raksha Bandhan', 'correct' => true],
                            ['text' => 'Christmas', 'correct' => false],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Guess the Local Brand',
                'description' => 'Identify logos and slogans of local brands',
                'questions' => [
                    [
                        'question' => 'Which brand\'s slogan is "Taste the Thunder"?',
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
                        'question' => 'Which brand\'s tagline is "The Taste of India"?',
                        'type' => 'mcq',
                        'difficulty' => 'medium',
                        'points' => 15,
                        'options' => [
                            ['text' => 'Amul', 'correct' => true],
                            ['text' => 'Mother Dairy', 'correct' => false],
                            ['text' => 'Britannia', 'correct' => false],
                            ['text' => 'Nestle', 'correct' => false],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Eco-Friendly Choices',
                'description' => 'Select eco-friendly local alternatives to common foreign products',
                'questions' => [
                    [
                        'question' => 'Which is more eco-friendly: local vegetables or imported ones?',
                        'type' => 'mcq',
                        'difficulty' => 'easy',
                        'points' => 10,
                        'options' => [
                            ['text' => 'Local vegetables', 'correct' => true],
                            ['text' => 'Imported vegetables', 'correct' => false],
                            ['text' => 'Same impact', 'correct' => false],
                            ['text' => 'Depends on season', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Select eco-friendly local alternatives:',
                        'type' => 'multi_select',
                        'difficulty' => 'medium',
                        'points' => 15,
                        'options' => [
                            ['text' => 'Bamboo products', 'correct' => true],
                            ['text' => 'Jute bags', 'correct' => true],
                            ['text' => 'Clay utensils', 'correct' => true],
                            ['text' => 'Plastic containers', 'correct' => false],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Supply Chain Explorer',
                'description' => 'Trace the journey of a product from raw material to consumer and identify local vs foreign dependencies',
                'questions' => [
                    [
                        'question' => 'How many countries does a typical smartphone supply chain involve?',
                        'type' => 'mcq',
                        'difficulty' => 'hard',
                        'points' => 20,
                        'options' => [
                            ['text' => '15-20 countries', 'correct' => true],
                            ['text' => '5-10 countries', 'correct' => false],
                            ['text' => '2-3 countries', 'correct' => false],
                            ['text' => '30-40 countries', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Select components of a local supply chain:',
                        'type' => 'multi_select',
                        'difficulty' => 'medium',
                        'points' => 15,
                        'options' => [
                            ['text' => 'Local farmers', 'correct' => true],
                            ['text' => 'Local processors', 'correct' => true],
                            ['text' => 'Local distributors', 'correct' => true],
                            ['text' => 'Local retailers', 'correct' => true],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Local Treasure Hunt (Digital)',
                'description' => 'Unlock clues about famous Indian products and brands',
                'questions' => [
                    [
                        'question' => 'Which Indian state is famous for tea production?',
                        'type' => 'mcq',
                        'difficulty' => 'easy',
                        'points' => 10,
                        'options' => [
                            ['text' => 'Assam', 'correct' => true],
                            ['text' => 'Kerala', 'correct' => false],
                            ['text' => 'Tamil Nadu', 'correct' => false],
                            ['text' => 'Karnataka', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Select famous Indian handicrafts:',
                        'type' => 'multi_select',
                        'difficulty' => 'medium',
                        'points' => 15,
                        'options' => [
                            ['text' => 'Kashmiri Shawls', 'correct' => true],
                            ['text' => 'Banarasi Silk', 'correct' => true],
                            ['text' => 'Madhubani Paintings', 'correct' => true],
                            ['text' => 'Pashmina Wool', 'correct' => true],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Sustainable Switch',
                'description' => 'Choose eco-friendly local alternatives and earn points',
                'questions' => [
                    [
                        'question' => 'Which is more sustainable: bamboo products or plastic products?',
                        'type' => 'mcq',
                        'difficulty' => 'easy',
                        'points' => 10,
                        'options' => [
                            ['text' => 'Bamboo products', 'correct' => true],
                            ['text' => 'Plastic products', 'correct' => false],
                            ['text' => 'Same impact', 'correct' => false],
                            ['text' => 'Depends on usage', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Select sustainable local alternatives:',
                        'type' => 'multi_select',
                        'difficulty' => 'medium',
                        'points' => 15,
                        'options' => [
                            ['text' => 'Cotton bags', 'correct' => true],
                            ['text' => 'Steel water bottles', 'correct' => true],
                            ['text' => 'Wooden utensils', 'correct' => true],
                            ['text' => 'Glass containers', 'correct' => true],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Make in India Memory Match',
                'description' => 'Match Indian brands with their products in a memory card game',
                'questions' => [
                    [
                        'question' => 'Which brand is associated with automobiles?',
                        'type' => 'mcq',
                        'difficulty' => 'easy',
                        'points' => 10,
                        'options' => [
                            ['text' => 'Tata Motors', 'correct' => true],
                            ['text' => 'Amul', 'correct' => false],
                            ['text' => 'TCS', 'correct' => false],
                            ['text' => 'Britannia', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Match brands with their industries:',
                        'type' => 'multi_select',
                        'difficulty' => 'medium',
                        'points' => 15,
                        'options' => [
                            ['text' => 'Tata - Steel & Automobiles', 'correct' => true],
                            ['text' => 'Amul - Dairy Products', 'correct' => true],
                            ['text' => 'TCS - IT Services', 'correct' => true],
                            ['text' => 'Reliance - Petrochemicals', 'correct' => true],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Local Startups Quiz',
                'description' => 'Identify upcoming Indian startups and their innovations',
                'questions' => [
                    [
                        'question' => 'Which Indian startup is known for digital payments?',
                        'type' => 'mcq',
                        'difficulty' => 'easy',
                        'points' => 10,
                        'options' => [
                            ['text' => 'Paytm', 'correct' => true],
                            ['text' => 'Flipkart', 'correct' => false],
                            ['text' => 'Ola', 'correct' => false],
                            ['text' => 'Zomato', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Select Indian startup success stories:',
                        'type' => 'multi_select',
                        'difficulty' => 'medium',
                        'points' => 15,
                        'options' => [
                            ['text' => 'Paytm - Digital Payments', 'correct' => true],
                            ['text' => 'Ola - Ride Sharing', 'correct' => true],
                            ['text' => 'Flipkart - E-commerce', 'correct' => true],
                            ['text' => 'Zomato - Food Delivery', 'correct' => true],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Price Comparison Challenge',
                'description' => 'Guess whether local or foreign products are more affordable',
                'questions' => [
                    [
                        'question' => 'Which is typically cheaper: local rice or imported rice?',
                        'type' => 'mcq',
                        'difficulty' => 'easy',
                        'points' => 10,
                        'options' => [
                            ['text' => 'Local rice', 'correct' => true],
                            ['text' => 'Imported rice', 'correct' => false],
                            ['text' => 'Same price', 'correct' => false],
                            ['text' => 'Depends on quality', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Select factors affecting product prices:',
                        'type' => 'multi_select',
                        'difficulty' => 'medium',
                        'points' => 15,
                        'options' => [
                            ['text' => 'Transportation costs', 'correct' => true],
                            ['text' => 'Import duties', 'correct' => true],
                            ['text' => 'Local taxes', 'correct' => true],
                            ['text' => 'Currency exchange rates', 'correct' => true],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Swadeshi Crossword',
                'description' => 'Solve a crossword featuring Indian brands and entrepreneurs',
                'questions' => [
                    [
                        'question' => 'What is the 5-letter word for an Indian dairy brand?',
                        'type' => 'mcq',
                        'difficulty' => 'easy',
                        'points' => 10,
                        'options' => [
                            ['text' => 'Amul', 'correct' => true],
                            ['text' => 'Nestle', 'correct' => false],
                            ['text' => 'Dabur', 'correct' => false],
                            ['text' => 'Britannia', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Solve the crossword: Indian automobile brand (4 letters)',
                        'type' => 'mcq',
                        'difficulty' => 'medium',
                        'points' => 15,
                        'options' => [
                            ['text' => 'Tata', 'correct' => true],
                            ['text' => 'Mahindra', 'correct' => false],
                            ['text' => 'Maruti', 'correct' => false],
                            ['text' => 'Bajaj', 'correct' => false],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Impact Meter',
                'description' => 'See the impact of your purchases by choosing local over foreign',
                'questions' => [
                    [
                        'question' => 'How much money stays in local economy when you buy local?',
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
                        'question' => 'Select impacts of buying local:',
                        'type' => 'multi_select',
                        'difficulty' => 'medium',
                        'points' => 15,
                        'options' => [
                            ['text' => 'Creates local jobs', 'correct' => true],
                            ['text' => 'Reduces carbon footprint', 'correct' => true],
                            ['text' => 'Supports local economy', 'correct' => true],
                            ['text' => 'Preserves local culture', 'correct' => true],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Guess the Origin',
                'description' => 'Identify the country of origin for famous brands',
                'questions' => [
                    [
                        'question' => 'Where was Samsung founded?',
                        'type' => 'mcq',
                        'difficulty' => 'easy',
                        'points' => 10,
                        'options' => [
                            ['text' => 'South Korea', 'correct' => true],
                            ['text' => 'Japan', 'correct' => false],
                            ['text' => 'China', 'correct' => false],
                            ['text' => 'Taiwan', 'correct' => false],
                        ],
                    ],
                    [
                        'question' => 'Select brands and their origins:',
                        'type' => 'multi_select',
                        'difficulty' => 'medium',
                        'points' => 15,
                        'options' => [
                            ['text' => 'Apple - USA', 'correct' => true],
                            ['text' => 'Samsung - South Korea', 'correct' => true],
                            ['text' => 'Toyota - Japan', 'correct' => true],
                            ['text' => 'Tata - India', 'correct' => true],
                        ],
                    ],
                ],
            ],
        ];

        foreach ($games as $gameData) {
            $this->createGameWithQuestions($gameData);
        }
    }

    /**
     * Create a game with its questions.
     */
    private function createGameWithQuestions(array $gameData): void
    {
        $game = \App\Models\Game::firstOrCreate(
            ['name' => $gameData['name']],
            ['description' => $gameData['description']]
        );

        foreach ($gameData['questions'] as $questionData) {
            $this->createQuestion($game, $questionData);
        }
    }

    /**
     * Create a question with its options.
     */
    private function createQuestion(\App\Models\Game $game, array $questionData): void
    {
        $question = \App\Models\GameQuestion::firstOrCreate([
            'game_id' => $game->id,
            'question' => $questionData['question'],
        ], [
            'type' => $questionData['type'],
            'difficulty' => $questionData['difficulty'],
            'points' => $questionData['points'],
        ]);

        // Create options for this question
        foreach ($questionData['options'] as $index => $optionData) {
            \App\Models\GameOption::firstOrCreate([
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
