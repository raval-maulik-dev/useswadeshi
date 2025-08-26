<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Game;
use App\Models\GameOption;
use App\Models\GameQuestion;
use App\Models\Product;
use Illuminate\Database\Seeder;

class GameQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find the "Swadeshi Challenge" game
        $swadeshiGame = Game::where('name', 'Swadeshi Challenge')->first();

        if (! $swadeshiGame) {
            $swadeshiGame = Game::create([
                'name' => 'Swadeshi Challenge',
                'description' => 'Test your knowledge about Indian products vs foreign products',
            ]);
        }

        // Create questions with mixed option types
        $this->createSwadeshiQuestions($swadeshiGame);
    }

    /**
     * Create Swadeshi Challenge questions with mixed option types.
     */
    private function createSwadeshiQuestions(Game $game): void
    {
        $questions = [
            [
                'question' => 'Which of the following is an Indian brand?',
                'type' => 'mcq',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'Samsung', 'correct' => false],
                    ['text' => 'Apple', 'correct' => false],
                    ['text' => 'Tata', 'correct' => true],
                    ['text' => 'Nike', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian brands from the following:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Reliance', 'correct' => true],
                    ['text' => 'Adidas', 'correct' => false],
                    ['text' => 'Mahindra', 'correct' => true],
                    ['text' => 'Coca-Cola', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Amul an Indian dairy brand?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 5,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which brand is known for "Make in India"?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'Maruti Suzuki', 'correct' => true],
                    ['text' => 'Toyota', 'correct' => false],
                    ['text' => 'Honda', 'correct' => false],
                    ['text' => 'Hyundai', 'correct' => false],
                ],
            ],
        ];

        foreach ($questions as $index => $questionData) {
            $question = GameQuestion::create([
                'game_id' => $game->id,
                'question' => $questionData['question'],
                'type' => $questionData['type'],
                'difficulty' => $questionData['difficulty'],
                'points' => $questionData['points'],
            ]);

            // Create options for this question
            foreach ($questionData['options'] as $optionIndex => $optionData) {
                GameOption::create([
                    'question_id' => $question->id,
                    'option_text' => $optionData['text'],
                    'optionable_id' => null,
                    'optionable_type' => null,
                    'is_correct' => $optionData['correct'],
                    'sort_order' => $optionIndex + 1,
                ]);
            }
        }

        // Create questions with brand-based options
        $this->createBrandBasedQuestions($game);

        // Create questions with product-based options
        $this->createProductBasedQuestions($game);
    }

    /**
     * Create questions with brand-based options.
     */
    private function createBrandBasedQuestions(Game $game): void
    {
        $brands = Brand::inRandomOrder()->limit(10)->get();

        if ($brands->count() >= 4) {
            $question = GameQuestion::create([
                'game_id' => $game->id,
                'question' => 'Which of these brands is Indian?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 15,
            ]);

            $correctBrand = $brands->where('country.name', 'India')->first() ?? $brands->first();
            $incorrectBrands = $brands->where('id', '!=', $correctBrand->id)->take(3);

            // Add correct option
            GameOption::create([
                'question_id' => $question->id,
                'optionable_id' => $correctBrand->id,
                'optionable_type' => Brand::class,
                'is_correct' => true,
                'sort_order' => 1,
            ]);

            // Add incorrect options
            foreach ($incorrectBrands as $index => $brand) {
                GameOption::create([
                    'question_id' => $question->id,
                    'optionable_id' => $brand->id,
                    'optionable_type' => Brand::class,
                    'is_correct' => false,
                    'sort_order' => $index + 2,
                ]);
            }
        }
    }

    /**
     * Create questions with product-based options.
     */
    private function createProductBasedQuestions(Game $game): void
    {
        $products = Product::with('brand')->inRandomOrder()->limit(10)->get();

        if ($products->count() >= 4) {
            $question = GameQuestion::create([
                'game_id' => $game->id,
                'question' => 'Which product is made by an Indian company?',
                'type' => 'mcq',
                'difficulty' => 'hard',
                'points' => 20,
            ]);

            $indianProducts = $products->filter(function ($product) {
                return $product->brand && $product->brand->country &&
                       $product->brand->country->name === 'India';
            });

            $correctProduct = $indianProducts->first() ?? $products->first();
            $incorrectProducts = $products->where('id', '!=', $correctProduct->id)->take(3);

            // Add correct option
            GameOption::create([
                'question_id' => $question->id,
                'optionable_id' => $correctProduct->id,
                'optionable_type' => Product::class,
                'is_correct' => true,
                'sort_order' => 1,
            ]);

            // Add incorrect options
            foreach ($incorrectProducts as $index => $product) {
                GameOption::create([
                    'question_id' => $question->id,
                    'optionable_id' => $product->id,
                    'optionable_type' => Product::class,
                    'is_correct' => false,
                    'sort_order' => $index + 2,
                ]);
            }
        }
    }

    /**
     * Create random options for a question.
     */
    private function createRandomOptions(GameQuestion $question): void
    {
        $optionCount = $question->type === 'true_false' ? 2 : 4;
        $correctCount = $question->type === 'multi_select' ? rand(1, 2) : 1;

        // Create text-based options
        for ($i = 0; $i < $optionCount; $i++) {
            GameOption::create([
                'question_id' => $question->id,
                'option_text' => fake()->words(2, true),
                'optionable_id' => null,
                'optionable_type' => null,
                'is_correct' => $i < $correctCount,
                'sort_order' => $i + 1,
            ]);
        }
    }
}
