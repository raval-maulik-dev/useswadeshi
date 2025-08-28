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

        // Create daily-use product based questions
        $this->createDailyUseProductQuestions($swadeshiGame);

        // Find or create the "Brand Recognition" game
        $brandRecognitionGame = Game::where('name', 'Brand Recognition')->first();

        if (! $brandRecognitionGame) {
            $brandRecognitionGame = Game::create([
                'name' => 'Brand Recognition',
                'description' => 'Identify whether brands are Indian or foreign',
            ]);
        }

        // Create brand recognition questions
        $this->createBrandRecognitionQuestions($brandRecognitionGame);
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
     * Create daily-use product based questions (household FMCG focus).
     */
    private function createDailyUseProductQuestions(Game $game): void
    {
        $dailyUseQuestions = [
            [
                'question' => 'Which toothpaste brand is Indian?',
                'type' => 'mcq',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'Dabur Red', 'correct' => true],
                    ['text' => 'Colgate', 'correct' => false],
                    ['text' => 'Sensodyne', 'correct' => false],
                    ['text' => 'Pepsodent', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian bathing soap brands:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Medimix', 'correct' => true],
                    ['text' => 'Cinthol', 'correct' => true],
                    ['text' => 'Lux', 'correct' => false],
                    ['text' => 'Dove', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Parle-G an Indian biscuit brand?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 5,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which instant noodles brand is Indian?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'YiPPee!', 'correct' => true],
                    ['text' => 'Maggi', 'correct' => false],
                    ['text' => 'Top Ramen', 'correct' => false],
                    ['text' => 'Koka', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian cooking oil brands:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Fortune', 'correct' => true],
                    ['text' => 'Saffola', 'correct' => true],
                    ['text' => 'Naturel', 'correct' => false],
                    ['text' => 'Bertolli', 'correct' => false],
                ],
            ],
            [
                'question' => 'Amul is an Indian dairy cooperative brand.',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 5,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which tea brand is Indian?',
                'type' => 'mcq',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'Tata Tea', 'correct' => true],
                    ['text' => 'Lipton', 'correct' => false],
                    ['text' => 'Tetley (global brand)', 'correct' => false],
                    ['text' => 'Twinings', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian spice brands:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'MDH', 'correct' => true],
                    ['text' => 'Everest', 'correct' => true],
                    ['text' => 'McCormick', 'correct' => false],
                    ['text' => 'Schwartz', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Ghadi an Indian detergent brand?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 5,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which packaged juice brand is Indian?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'Paper Boat', 'correct' => true],
                    ['text' => 'Minute Maid', 'correct' => false],
                    ['text' => 'Tropicana', 'correct' => false],
                    ['text' => 'V8', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian handwash brands:',
                'type' => 'multi_select',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'Savlon (ITC)', 'correct' => true],
                    ['text' => 'Dettol', 'correct' => false],
                    ['text' => 'Himalaya', 'correct' => true],
                    ['text' => 'Palmolive', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which antiseptic liquid is from an Indian company?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'Savlon', 'correct' => true],
                    ['text' => 'Dettol (Reckitt)', 'correct' => false],
                    ['text' => 'Betadine', 'correct' => false],
                    ['text' => 'Bactine', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Nirma an Indian detergent brand?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 5,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which cooking salt brand is Indian?',
                'type' => 'mcq',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'Tata Salt', 'correct' => true],
                    ['text' => 'Morton Salt', 'correct' => false],
                    ['text' => 'Saxa', 'correct' => false],
                    ['text' => 'Hain Pure Foods', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian atta (wheat flour) brands:',
                'type' => 'multi_select',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'Aashirvaad', 'correct' => true],
                    ['text' => 'Pillsbury', 'correct' => false],
                    ['text' => 'Fortune Chakki Fresh', 'correct' => true],
                    ['text' => 'Gold Medal', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Basmati rice brand India Gate Indian-owned?',
                'type' => 'true_false',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which hair oil brand is Indian?',
                'type' => 'mcq',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'Parachute', 'correct' => true],
                    ['text' => 'Garnier Fructis Oil', 'correct' => false],
                    ['text' => 'Pantene Oil Replacement', 'correct' => false],
                    ['text' => 'L’Oréal Elvive Oil', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian shampoo brands:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Clinic Plus', 'correct' => true],
                    ['text' => 'Sunsilk', 'correct' => false],
                    ['text' => 'Dabur Vatika', 'correct' => true],
                    ['text' => 'Head & Shoulders', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Fevicol an Indian adhesive brand?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 5,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which packaged snack brand is Indian?',
                'type' => 'mcq',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'Haldiram’s', 'correct' => true],
                    ['text' => 'Pringles', 'correct' => false],
                    ['text' => 'Lay’s', 'correct' => false],
                    ['text' => 'Doritos', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian dairy brands:',
                'type' => 'multi_select',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'Mother Dairy', 'correct' => true],
                    ['text' => 'Amul', 'correct' => true],
                    ['text' => 'Lactalis', 'correct' => false],
                    ['text' => 'Arla', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Boroline an Indian skincare brand?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 5,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which packaged water brand is Indian-owned?',
                'type' => 'mcq',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'Bisleri', 'correct' => true],
                    ['text' => 'Aquafina', 'correct' => false],
                    ['text' => 'Kinley', 'correct' => false],
                    ['text' => 'Evian', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian biscuit brands:',
                'type' => 'multi_select',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'Parle', 'correct' => true],
                    ['text' => 'Britannia', 'correct' => true],
                    ['text' => 'Oreo', 'correct' => false],
                    ['text' => 'LU', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Prestige an Indian kitchen appliances brand?',
                'type' => 'true_false',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which masala noodles brand is Indian?',
                'type' => 'mcq',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'Ching’s Secret', 'correct' => true],
                    ['text' => 'Indomie', 'correct' => false],
                    ['text' => 'Nissin Cup Noodles', 'correct' => false],
                    ['text' => 'Samyang', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian home cleaner brands:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Lizol', 'correct' => false],
                    ['text' => 'Harpic', 'correct' => false],
                    ['text' => 'Gainda', 'correct' => true],
                    ['text' => 'Formula 409', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is BoroPlus an Indian personal care brand?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 5,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which ghee brand is Indian?',
                'type' => 'mcq',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'Amul Ghee', 'correct' => true],
                    ['text' => 'President Ghee', 'correct' => false],
                    ['text' => 'Kerrygold Ghee', 'correct' => false],
                    ['text' => 'Anchor Ghee', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian edible oil companies:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Marico (Saffola)', 'correct' => true],
                    ['text' => 'Adani Wilmar (Fortune)', 'correct' => true],
                    ['text' => 'Borges', 'correct' => false],
                    ['text' => 'Filippo Berio', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Hamdard (RoohAfza) an Indian brand?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 5,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which honey brand is Indian?',
                'type' => 'mcq',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'Dabur Honey', 'correct' => true],
                    ['text' => "Manuka Health", 'correct' => false],
                    ['text' => 'Langnese', 'correct' => false],
                    ['text' => 'Capilano', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian namkeen/snack brands:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Bikaji', 'correct' => true],
                    ['text' => 'Balaji Wafers', 'correct' => true],
                    ['text' => 'Cheetos', 'correct' => false],
                    ['text' => 'Kettle Brand', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is VICCO an Indian ayurvedic brand?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 5,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which talcum powder brand is Indian?',
                'type' => 'mcq',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'Nycil', 'correct' => true],
                    ['text' => 'Johnson’s Baby Powder', 'correct' => false],
                    ['text' => 'Ponds Talc', 'correct' => false],
                    ['text' => 'Nivea Talc', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian household matchbox/agarbatti brands:',
                'type' => 'multi_select',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'Cycle Pure Agarbathies', 'correct' => true],
                    ['text' => 'WIMCO (legacy India brand)', 'correct' => true],
                    ['text' => 'Diamond (US)', 'correct' => false],
                    ['text' => 'BIC', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Pidilite (Fevikwik) an Indian company?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 5,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which toothbrush/ayurvedic oral care brand is Indian?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'Vicco Vajradanti', 'correct' => true],
                    ['text' => 'Oral-B', 'correct' => false],
                    ['text' => 'Colgate Total', 'correct' => false],
                    ['text' => 'Sensodyne Rapid', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian herbal personal care brands:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Himalaya', 'correct' => true],
                    ['text' => 'Biotique', 'correct' => true],
                    ['text' => 'Garnier', 'correct' => false],
                    ['text' => 'Nivea', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Godrej No.1 an Indian bathing soap brand?',
                'type' => 'true_false',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which dishwash brand is Indian?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'Vim', 'correct' => false],
                    ['text' => 'Pril', 'correct' => false],
                    ['text' => 'Exo', 'correct' => true],
                    ['text' => 'Finish', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian mosquito repellent brands:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'All Out', 'correct' => false],
                    ['text' => 'Goodknight', 'correct' => true],
                    ['text' => 'Maxo', 'correct' => true],
                    ['text' => 'Raid', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Asian Paints Trucare a home care/cleaning range by an Indian brand?',
                'type' => 'true_false',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which floor cleaner brand is Indian?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'Lizol', 'correct' => false],
                    ['text' => 'Harpic', 'correct' => false],
                    ['text' => 'Gainda Phenyl', 'correct' => true],
                    ['text' => 'Mr Muscle', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian sanitary pad brands:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Sofy', 'correct' => false],
                    ['text' => 'Nua', 'correct' => true],
                    ['text' => 'Paree', 'correct' => true],
                    ['text' => 'Whisper', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Supremia or Snuggy an Indian baby diaper brand (Nobel Hygiene)?',
                'type' => 'true_false',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which pressure cooker brand is Indian-owned?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'Prestige', 'correct' => true],
                    ['text' => 'Hawkins', 'correct' => true],
                    ['text' => 'Tefal', 'correct' => false],
                    ['text' => 'Presto', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian mixer-grinder brands:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Preethi', 'correct' => true],
                    ['text' => 'Butterfly', 'correct' => true],
                    ['text' => 'KitchenAid', 'correct' => false],
                    ['text' => 'Bosch', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Kent an Indian water purifier brand?',
                'type' => 'true_false',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which air cooler brand is Indian-origin?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'Symphony', 'correct' => true],
                    ['text' => 'Honeywell', 'correct' => false],
                    ['text' => 'Whirlpool', 'correct' => false],
                    ['text' => 'Midea', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian ball pen/stationery brands:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Cello', 'correct' => true],
                    ['text' => 'Nataraj (Hindustan Pencils)', 'correct' => true],
                    ['text' => 'Parker', 'correct' => false],
                    ['text' => 'Pilot', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Linc an Indian writing instruments brand?',
                'type' => 'true_false',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which footwear brand is Indian-owned?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'Bata India (licensed operations in India)', 'correct' => true],
                    ['text' => 'Adidas', 'correct' => false],
                    ['text' => 'Reebok', 'correct' => false],
                    ['text' => 'Skechers', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian umbrella/rainwear brands:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Duckback', 'correct' => true],
                    ['text' => 'Wildcraft (India)', 'correct' => true],
                    ['text' => 'Columbia', 'correct' => false],
                    ['text' => 'The North Face', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Eveready an Indian-origin batteries/lighting brand?',
                'type' => 'true_false',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which LED lighting brand is Indian?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'Syska', 'correct' => true],
                    ['text' => 'Philips', 'correct' => false],
                    ['text' => 'Osram', 'correct' => false],
                    ['text' => 'GE Lighting', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian incense/pooja brands:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Cycle Pure', 'correct' => true],
                    ['text' => 'Moksh Agarbatti', 'correct' => true],
                    ['text' => 'Hemani', 'correct' => false],
                    ['text' => 'Satya (Shrinivas Sugandhalaya, India)', 'correct' => true],
                ],
            ],
            [
                'question' => 'Is Santoor an Indian soap brand (Wipro Consumer)?',
                'type' => 'true_false',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which deodorant/perfume brand is Indian-origin?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'Fogg', 'correct' => true],
                    ['text' => 'AXE', 'correct' => false],
                    ['text' => 'Dior Sauvage', 'correct' => false],
                    ['text' => 'Old Spice', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian ready-to-cook snack brands:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'MTR', 'correct' => true],
                    ['text' => 'Gits', 'correct' => true],
                    ['text' => 'Knorr', 'correct' => false],
                    ['text' => 'Kraft Heinz', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Patanjali Dant Kanti an Indian toothpaste brand?',
                'type' => 'true_false',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which pressure cooker gasket/whistle spare brand is Indian?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'Hawkins Original', 'correct' => true],
                    ['text' => 'Prestige USA', 'correct' => false],
                    ['text' => 'Presto US', 'correct' => false],
                    ['text' => 'T-fal', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian steel utensils brands:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Vinod', 'correct' => true],
                    ['text' => 'Milton', 'correct' => true],
                    ['text' => 'ZWILLING', 'correct' => false],
                    ['text' => 'WMF', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Pigeon an Indian kitchenware brand (Stovekraft)?',
                'type' => 'true_false',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which storage container brand is Indian?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'Cello Plastics', 'correct' => true],
                    ['text' => 'Tupperware', 'correct' => false],
                    ['text' => 'Sistema', 'correct' => false],
                    ['text' => 'Rubbermaid', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian incense cone/dhoop brands:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Zed Black', 'correct' => true],
                    ['text' => 'Cycle 3-in-1', 'correct' => true],
                    ['text' => 'Air Wick', 'correct' => false],
                    ['text' => 'Glade', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Sulekha or Camlin an Indian ink/stationery brand?',
                'type' => 'true_false',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which pressure pan/multiple-use cooker brand is Indian?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'Prestige Clip-On', 'correct' => true],
                    ['text' => 'Cuisinart', 'correct' => false],
                    ['text' => 'All-Clad', 'correct' => false],
                    ['text' => 'Calphalon', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian oats/breakfast brands:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Saffola Oats', 'correct' => true],
                    ['text' => 'Kellogg’s', 'correct' => false],
                    ['text' => 'Yogabar (India)', 'correct' => true],
                    ['text' => 'Quaker', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Milton (thermos/flasks) an Indian brand?',
                'type' => 'true_false',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which ready-to-drink beverage brand is Indian-origin?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'Frooti', 'correct' => true],
                    ['text' => 'Minute Maid', 'correct' => false],
                    ['text' => 'Capri-Sun', 'correct' => false],
                    ['text' => 'Ribena', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian pickle (achaar) brands:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Pachranga', 'correct' => true],
                    ['text' => 'Mother’s Recipe', 'correct' => true],
                    ['text' => 'Mrs. Ball’s', 'correct' => false],
                    ['text' => 'Heinz Pickles', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Anil or Bambino an Indian vermicelli/seviyan brand?',
                'type' => 'true_false',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which poha/suji upma brand is Indian?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'MTR Breakfast Mix', 'correct' => true],
                    ['text' => 'Betty Crocker', 'correct' => false],
                    ['text' => 'Quaker Oatmeal Express', 'correct' => false],
                    ['text' => 'Annie’s Homegrown', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian papad brands:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Lijjat', 'correct' => true],
                    ['text' => 'Bikaji Papad', 'correct' => true],
                    ['text' => 'Utz', 'correct' => false],
                    ['text' => 'Walkers', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Prestige IRIS a mixer-grinder model from an Indian brand?',
                'type' => 'true_false',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which pressure washer/cleaning appliance brand is Indian-origin?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'Agaro', 'correct' => true],
                    ['text' => 'Kärcher', 'correct' => false],
                    ['text' => 'Bosch Home', 'correct' => false],
                    ['text' => 'Nilfisk', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian spice mix (ready masala) brands:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Catch Masala', 'correct' => true],
                    ['text' => 'Everest Masala', 'correct' => true],
                    ['text' => 'Schwartz Mixes', 'correct' => false],
                    ['text' => 'Cole & Mason', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Nilkamal a plastic furniture/storage brand from India?',
                'type' => 'true_false',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which ready mix idli/dosa batter brand is Indian-origin?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'iD Fresh', 'correct' => true],
                    ['text' => 'Betty Crocker', 'correct' => false],
                    ['text' => 'Pioneer', 'correct' => false],
                    ['text' => 'Aunt Jemima', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian lentils/pulses brands:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Tata Sampann', 'correct' => true],
                    ['text' => '24 Mantra Organic', 'correct' => true],
                    ['text' => 'Goya', 'correct' => false],
                    ['text' => 'Heinz Beanz', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Borosil an Indian glassware/kitchen brand?',
                'type' => 'true_false',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which Indian-origin herbal hair color brand is commonly found in daily use?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'Godrej Expert', 'correct' => true],
                    ['text' => 'L’Oréal Excellence', 'correct' => false],
                    ['text' => 'Schwarzkopf Igora', 'correct' => false],
                    ['text' => 'Clairol Nice’n Easy', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian shaving/men’s grooming brands:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Bombay Shaving Company', 'correct' => true],
                    ['text' => 'Ustraa', 'correct' => true],
                    ['text' => 'Gillette', 'correct' => false],
                    ['text' => 'Harry’s', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Park Avenue (fragrance/grooming) an Indian brand (Raymond)?',
                'type' => 'true_false',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which Indian-origin brand makes copper water bottles (daily wellness)?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'TAGG or Indian Art Villa', 'correct' => true],
                    ['text' => 'Thermos', 'correct' => false],
                    ['text' => 'Contigo', 'correct' => false],
                    ['text' => 'Hydro Flask', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian jaggery/gur brands:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Patanjali Jaggery', 'correct' => true],
                    ['text' => 'Organic India Jaggery', 'correct' => true],
                    ['text' => 'C&H Sugar', 'correct' => false],
                    ['text' => 'Domino Sugar', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Prestige PIC a series of induction cooktops from an Indian brand?',
                'type' => 'true_false',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which Indian-origin RO water purifier salt/cleaning kit brand is common?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'Kent Genuine Kit', 'correct' => true],
                    ['text' => 'Brita Maxtra', 'correct' => false],
                    ['text' => 'Culligan', 'correct' => false],
                    ['text' => 'GE SmartWater', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian pooja camphor/kapur brands:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Mangalam Camphor', 'correct' => true],
                    ['text' => 'Mangaldeep (ITC)', 'correct' => true],
                    ['text' => 'Air Wick', 'correct' => false],
                    ['text' => 'Yankee Candle', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Parry’s Sugar an Indian refined sugar brand?',
                'type' => 'true_false',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which Indian-origin pressure kettle/tea kettle brand is common at homes?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'Pigeon by Stovekraft', 'correct' => true],
                    ['text' => 'Hamilton Beach', 'correct' => false],
                    ['text' => 'Breville', 'correct' => false],
                    ['text' => 'Cuisinart', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian mouth freshener/saunf brands:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Manikchand (Pan Masala company) – exclude; choose F&B', 'correct' => false],
                    ['text' => 'Patanjali Mouth Freshener', 'correct' => true],
                    ['text' => 'Chandan Mouth Freshener', 'correct' => true],
                    ['text' => 'Mentos Mint', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Prestige Omega a cookware series from an Indian brand?',
                'type' => 'true_false',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which of these is an Indian brand of kitchen storage containers?',
                'type' => 'mcq',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'Tupperware', 'correct' => false],
                    ['text' => 'Borosil', 'correct' => true],
                    ['text' => 'Tupperware', 'correct' => false],
                    ['text' => 'Lock & Lock', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian brands of tea:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Taj Mahal', 'correct' => true],
                    ['text' => 'Red Label', 'correct' => true],
                    ['text' => 'Lipton', 'correct' => false],
                    ['text' => 'Tetley', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Amul an Indian dairy brand?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which of these is an Indian brand of pressure cookers?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'Hawkins', 'correct' => true],
                    ['text' => 'Instant Pot', 'correct' => false],
                    ['text' => 'T-fal', 'correct' => false],
                    ['text' => 'Crock-Pot', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian brands of spices:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'MDH', 'correct' => true],
                    ['text' => 'Everest', 'correct' => true],
                    ['text' => 'McCormick', 'correct' => false],
                    ['text' => 'Badia', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Patanjali an Indian brand?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which of these is an Indian brand of floor cleaners?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 10,
                'options' => [
                    ['text' => 'Lizol', 'correct' => false],
                    ['text' => 'Harpic', 'correct' => false],
                    ['text' => 'Nimyle', 'correct' => true],
                    ['text' => 'Dettol', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian brands of snacks:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Haldiram\'s', 'correct' => true],
                    ['text' => 'Bikaji', 'correct' => true],
                    ['text' => 'Lay\'s', 'correct' => false],
                    ['text' => 'Pringles', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Nirma an Indian detergent brand?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ]
        ];

        foreach ($dailyUseQuestions as $questionData) {
            $question = GameQuestion::create([
                'game_id' => $game->id,
                'question' => $questionData['question'],
                'type' => $questionData['type'],
                'difficulty' => $questionData['difficulty'],
                'points' => $questionData['points'],
            ]);

            foreach ($questionData['options'] as $index => $optionData) {
                GameOption::create([
                    'question_id' => $question->id,
                    'option_text' => $optionData['text'],
                    'optionable_id' => null,
                    'optionable_type' => null,
                    'is_correct' => $optionData['correct'],
                    'sort_order' => $index + 1,
                ]);
            }
        }
    }

    /**
     * Create brand recognition questions.
     */
    private function createBrandRecognitionQuestions(Game $game): void
    {
        $questions = [
            [
                'question' => 'Is Tata Motors an Indian automotive company?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which of these is an Indian FMCG company?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Unilever', 'correct' => false],
                    ['text' => 'ITC Limited', 'correct' => true],
                    ['text' => 'P&G', 'correct' => false],
                    ['text' => 'Nestle', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian tech companies:',
                'type' => 'multi_select',
                'difficulty' => 'hard',
                'points' => 20,
                'options' => [
                    ['text' => 'Infosys', 'correct' => true],
                    ['text' => 'TCS', 'correct' => true],
                    ['text' => 'Accenture', 'correct' => false],
                    ['text' => 'Wipro', 'correct' => true],
                ],
            ],
            [
                'question' => 'Is Samsung an Indian electronics brand?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => false],
                    ['text' => 'False', 'correct' => true],
                ],
            ],
            [
                'question' => 'Which Indian company owns Jio?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Reliance Industries', 'correct' => true],
                    ['text' => 'Tata Group', 'correct' => false],
                    ['text' => 'Adani Group', 'correct' => false],
                    ['text' => 'Mahindra Group', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian automobile manufacturers:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 20,
                'options' => [
                    ['text' => 'Maruti Suzuki', 'correct' => true],
                    ['text' => 'Tata Motors', 'correct' => true],
                    ['text' => 'Hyundai', 'correct' => false],
                    ['text' => 'Mahindra', 'correct' => true],
                ],
            ],
            [
                'question' => 'Is Haldiram\'s an Indian snacks brand?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which of these is an Indian e-commerce company?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Flipkart', 'correct' => true],
                    ['text' => 'Amazon', 'correct' => false],
                    ['text' => 'eBay', 'correct' => false],
                    ['text' => 'Alibaba', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Zara an Indian clothing brand?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => false],
                    ['text' => 'False', 'correct' => true],
                ],
            ],
            [
                'question' => 'Which Indian company owns Taj Hotels?',
                'type' => 'mcq',
                'difficulty' => 'hard',
                'points' => 20,
                'options' => [
                    ['text' => 'Tata Group', 'correct' => true],
                    ['text' => 'Reliance Industries', 'correct' => false],
                    ['text' => 'Aditya Birla Group', 'correct' => false],
                    ['text' => 'Mahindra Group', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian pharmaceutical companies:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 20,
                'options' => [
                    ['text' => 'Sun Pharma', 'correct' => true],
                    ['text' => 'Dr. Reddy\'s', 'correct' => true],
                    ['text' => 'Pfizer', 'correct' => false],
                    ['text' => 'Cipla', 'correct' => true],
                ],
            ],
            [
                'question' => 'Is Patanjali an Indian FMCG company?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which of these is an Indian airline company?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'IndiGo', 'correct' => true],
                    ['text' => 'Emirates', 'correct' => false],
                    ['text' => 'Singapore Airlines', 'correct' => false],
                    ['text' => 'Qatar Airways', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian banking institutions:',
                'type' => 'multi_select',
                'difficulty' => 'hard',
                'points' => 20,
                'options' => [
                    ['text' => 'SBI', 'correct' => true],
                    ['text' => 'HDFC Bank', 'correct' => true],
                    ['text' => 'Standard Chartered', 'correct' => false],
                    ['text' => 'ICICI Bank', 'correct' => true],
                ],
            ],
            [
                'question' => 'Is Bata an Indian footwear brand?',
                'type' => 'true_false',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'True', 'correct' => false],
                    ['text' => 'False', 'correct' => true],
                ],
            ],
            [
                'question' => 'Which of these is an Indian steel company?',
                'type' => 'mcq',
                'difficulty' => 'hard',
                'points' => 20,
                'options' => [
                    ['text' => 'Tata Steel', 'correct' => true],
                    ['text' => 'ArcelorMittal', 'correct' => false],
                    ['text' => 'POSCO', 'correct' => false],
                    ['text' => 'Nippon Steel', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Asian Paints an Indian company?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which of these is an Indian telecom operator?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Airtel', 'correct' => true],
                    ['text' => 'Vodafone', 'correct' => false],
                    ['text' => 'Verizon', 'correct' => false],
                    ['text' => 'AT&T', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian media companies:',
                'type' => 'multi_select',
                'difficulty' => 'hard',
                'points' => 20,
                'options' => [
                    ['text' => 'Zee Entertainment', 'correct' => true],
                    ['text' => 'Sony Pictures', 'correct' => false],
                    ['text' => 'Star India', 'correct' => true],
                    ['text' => 'Disney', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Raymond an Indian textile brand?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Britannia an Indian FMCG company?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which of these is an Indian automobile company that owns Royal Enfield?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Eicher Motors', 'correct' => true],
                    ['text' => 'Bajaj Auto', 'correct' => false],
                    ['text' => 'TVS Motors', 'correct' => false],
                    ['text' => 'Hero MotoCorp', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian jewelry brands:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 20,
                'options' => [
                    ['text' => 'Tanishq', 'correct' => true],
                    ['text' => 'Kalyan Jewellers', 'correct' => true],
                    ['text' => 'Tiffany & Co.', 'correct' => false],
                    ['text' => 'Malabar Gold', 'correct' => true],
                ],
            ],
            [
                'question' => 'Is MRF an Indian tire manufacturing company?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which of these is an Indian paint company?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Asian Paints', 'correct' => true],
                    ['text' => 'Dulux', 'correct' => false],
                    ['text' => 'Berger', 'correct' => false],
                    ['text' => 'Nerolac', 'correct' => true],
                ],
            ],
            [
                'question' => 'Is Dabur an Indian consumer goods company?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which of these is an Indian two-wheeler manufacturer?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Bajaj Auto', 'correct' => true],
                    ['text' => 'Honda', 'correct' => false],
                    ['text' => 'Yamaha', 'correct' => false],
                    ['text' => 'Suzuki', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian watch brands:',
                'type' => 'multi_select',
                'difficulty' => 'hard',
                'points' => 20,
                'options' => [
                    ['text' => 'Titan', 'correct' => true],
                    ['text' => 'HMT', 'correct' => true],
                    ['text' => 'Timex', 'correct' => false],
                    ['text' => 'Fastrack', 'correct' => true],
                ],
            ],
            [
                'question' => 'Is Godrej an Indian conglomerate?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which of these is an Indian airline company?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'SpiceJet', 'correct' => true],
                    ['text' => 'Emirates', 'correct' => false],
                    ['text' => 'Singapore Airlines', 'correct' => false],
                    ['text' => 'Qatar Airways', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian tea brands:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 20,
                'options' => [
                    ['text' => 'Taj Mahal', 'correct' => true],
                    ['text' => 'Tetley', 'correct' => false],
                    ['text' => 'Wagh Bakri', 'correct' => true],
                    ['text' => 'Society Tea', 'correct' => true],
                ],
            ],
            [
                'question' => 'Is Parle an Indian food products company?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which of these is an Indian IT services company?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'HCL Technologies', 'correct' => true],
                    ['text' => 'Accenture', 'correct' => false],
                    ['text' => 'IBM', 'correct' => false],
                    ['text' => 'Capgemini', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Havells an Indian consumer electrical equipment company?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which of these is an Indian cement company?',
                'type' => 'mcq',
                'difficulty' => 'hard',
                'points' => 20,
                'options' => [
                    ['text' => 'UltraTech', 'correct' => true],
                    ['text' => 'Lafarge', 'correct' => false],
                    ['text' => 'Heidelberg', 'correct' => false],
                    ['text' => 'Holcim', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian clothing brands:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 20,
                'options' => [
                    ['text' => 'Fabindia', 'correct' => true],
                    ['text' => 'Biba', 'correct' => true],
                    ['text' => 'Zara', 'correct' => false],
                    ['text' => 'W for Woman', 'correct' => true],
                ],
            ],
            [
                'question' => 'Is Apollo Tyres an Indian company?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which of these is an Indian insurance company?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'L&T Insurance', 'correct' => true],
                    ['text' => 'Prudential', 'correct' => false],
                    ['text' => 'AIA', 'correct' => false],
                    ['text' => 'Axa', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian food delivery platforms:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 20,
                'options' => [
                    ['text' => 'Swiggy', 'correct' => true],
                    ['text' => 'Zomato', 'correct' => true],
                    ['text' => 'Uber Eats', 'correct' => false],
                    ['text' => 'Foodpanda', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Titan an Indian watch and jewelry company?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Amul an Indian dairy cooperative?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which of these is an Indian e-commerce company?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Flipkart', 'correct' => true],
                    ['text' => 'Amazon', 'correct' => false],
                    ['text' => 'eBay', 'correct' => false],
                    ['text' => 'Walmart', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian bicycle brands:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 20,
                'options' => [
                    ['text' => 'Hero Cycles', 'correct' => true],
                    ['text' => 'Atlas Cycles', 'correct' => true],
                    ['text' => 'Trek', 'correct' => false],
                    ['text' => 'BSA', 'correct' => true],
                ],
            ],
            [
                'question' => 'Is JCB an Indian construction equipment company?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => false],
                    ['text' => 'False', 'correct' => true],
                ],
            ],
            [
                'question' => 'Which of these is an Indian smartphone brand?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Micromax', 'correct' => true],
                    ['text' => 'Samsung', 'correct' => false],
                    ['text' => 'Xiaomi', 'correct' => false],
                    ['text' => 'Oppo', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Nirma an Indian detergent brand?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which of these is an Indian airline that operates international flights?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Air India', 'correct' => true],
                    ['text' => 'IndiGo', 'correct' => true],
                    ['text' => 'SpiceJet', 'correct' => true],
                    ['text' => 'Vistara', 'correct' => true],
                ],
            ],
            [
                'question' => 'Select all Indian chocolate brands:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 20,
                'options' => [
                    ['text' => 'Amul', 'correct' => true],
                    ['text' => 'Cadbury', 'correct' => false],
                    ['text' => 'Nestle', 'correct' => false],
                    ['text' => 'Campco', 'correct' => true],
                ],
            ],
            [
                'question' => 'Is LIC an Indian insurance company?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which of these is an Indian motorcycle brand?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Royal Enfield', 'correct' => true],
                    ['text' => 'Honda', 'correct' => false],
                    ['text' => 'Yamaha', 'correct' => false],
                    ['text' => 'Suzuki', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian news channels:',
                'type' => 'multi_select',
                'difficulty' => 'hard',
                'points' => 20,
                'options' => [
                    ['text' => 'Aaj Tak', 'correct' => true],
                    ['text' => 'Republic TV', 'correct' => true],
                    ['text' => 'BBC', 'correct' => false],
                    ['text' => 'NDTV India', 'correct' => true],
                ],
            ],
            [
                'question' => 'Is Patanjali an Indian FMCG company?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which of these is an Indian biscuit brand?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Parle-G', 'correct' => true],
                    ['text' => 'Oreo', 'correct' => false],
                    ['text' => 'McVitie\'s', 'correct' => false],
                    ['text' => 'Hidustan Unilever', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Zoho an Indian software company?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which of these is an Indian watch brand?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Titan', 'correct' => true],
                    ['text' => 'Rolex', 'correct' => false],
                    ['text' => 'Casio', 'correct' => false],
                    ['text' => 'Timex', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian automobile manufacturers:',
                'type' => 'multi_select',
                'difficulty' => 'hard',
                'points' => 20,
                'options' => [
                    ['text' => 'Tata Motors', 'correct' => true],
                    ['text' => 'Mahindra', 'correct' => true],
                    ['text' => 'Maruti Suzuki', 'correct' => true],
                    ['text' => 'Hyundai', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Big Bazaar an Indian retail chain?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which of these is an Indian payment app?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'PhonePe', 'correct' => true],
                    ['text' => 'PayPal', 'correct' => false],
                    ['text' => 'Venmo', 'correct' => false],
                    ['text' => 'WeChat Pay', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian telecom operators:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 20,
                'options' => [
                    ['text' => 'Airtel', 'correct' => true],
                    ['text' => 'Jio', 'correct' => true],
                    ['text' => 'Vodafone Idea', 'correct' => true],
                    ['text' => 'Verizon', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Byju\'s an Indian edtech company?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which of these is an Indian spice brand?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'MDH', 'correct' => true],
                    ['text' => 'McCormick', 'correct' => false],
                    ['text' => 'Badia', 'correct' => false],
                    ['text' => 'Schwartz', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Hindustan Unilever an Indian company?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => false],
                    ['text' => 'False', 'correct' => true],
                ],
            ],
            [
                'question' => 'Which of these is an Indian airline that operates only domestic flights?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'IndiGo', 'correct' => true],
                    ['text' => 'Air India', 'correct' => false],
                    ['text' => 'Vistara', 'correct' => false],
                    ['text' => 'SpiceJet', 'correct' => true],
                ],
            ],
            [
                'question' => 'Select all Indian home appliance brands:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 20,
                'options' => [
                    ['text' => 'Bajaj', 'correct' => true],
                    ['text' => 'Havells', 'correct' => true],
                    ['text' => 'Samsung', 'correct' => false],
                    ['text' => 'Orient Electric', 'correct' => true],
                ],
            ],
            [
                'question' => 'Is MakeMyTrip an Indian travel company?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which of these is an Indian payment gateway?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Razorpay', 'correct' => true],
                    ['text' => 'PayPal', 'correct' => false],
                    ['text' => 'Stripe', 'correct' => false],
                    ['text' => 'Square', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian footwear brands:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 20,
                'options' => [
                    ['text' => 'Bata', 'correct' => false],
                    ['text' => 'Liberty', 'correct' => true],
                    ['text' => 'Paragon', 'correct' => true],
                    ['text' => 'Nike', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Nykaa an Indian beauty e-commerce company?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which of these is an Indian food delivery company?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Zomato', 'correct' => true],
                    ['text' => 'Uber Eats', 'correct' => false],
                    ['text' => 'DoorDash', 'correct' => false],
                    ['text' => 'Grubhub', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian news apps:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 20,
                'options' => [
                    ['text' => 'Inshorts', 'correct' => true],
                    ['text' => 'Dailyhunt', 'correct' => true],
                    ['text' => 'Google News', 'correct' => false],
                    ['text' => 'NewsBreak', 'correct' => false],
                ],
            ],
            [
                'question' => 'Is Boat an Indian consumer electronics brand?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which of these is an Indian online grocery store?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'BigBasket', 'correct' => true],
                    ['text' => 'Amazon Fresh', 'correct' => false],
                    ['text' => 'Instacart', 'correct' => false],
                    ['text' => 'Walmart Grocery', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian furniture brands:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 20,
                'options' => [
                    ['text' => 'Pepperfry', 'correct' => true],
                    ['text' => 'Urban Ladder', 'correct' => true],
                    ['text' => 'IKEA', 'correct' => false],
                    ['text' => 'Nilkamal', 'correct' => true],
                ],
            ],
            [
                'question' => 'Is Crompton an Indian consumer electronics company?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which of these is an Indian online learning platform?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Unacademy', 'correct' => true],
                    ['text' => 'Coursera', 'correct' => false],
                    ['text' => 'Udemy', 'correct' => false],
                    ['text' => 'edX', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian luggage brands:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 20,
                'options' => [
                    ['text' => 'VIP', 'correct' => true],
                    ['text' => 'Safari', 'correct' => true],
                    ['text' => 'American Tourister', 'correct' => false],
                    ['text' => 'Skybags', 'correct' => true],
                ],
            ],
            [
                'question' => 'Is Paper Boat an Indian beverage brand?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which of these is an Indian social media platform?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'ShareChat', 'correct' => true],
                    ['text' => 'Facebook', 'correct' => false],
                    ['text' => 'Twitter', 'correct' => false],
                    ['text' => 'Instagram', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian bicycle manufacturers:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 20,
                'options' => [
                    ['text' => 'Hero Cycles', 'correct' => true],
                    ['text' => 'Atlas Cycles', 'correct' => true],
                    ['text' => 'Trek', 'correct' => false],
                    ['text' => 'BSA', 'correct' => true],
                ],
            ],
            [
                'question' => 'Is Lenskart an Indian eyewear brand?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which of these is an Indian eyewear retailer?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Lenskart', 'correct' => true],
                    ['text' => 'Specsavers', 'correct' => false],
                    ['text' => 'Vision Express', 'correct' => false],
                    ['text' => 'Pearle Vision', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian fashion e-commerce platforms:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 20,
                'options' => [
                    ['text' => 'Myntra', 'correct' => true],
                    ['text' => 'Ajio', 'correct' => true],
                    ['text' => 'ASOS', 'correct' => false],
                    ['text' => 'Zivame', 'correct' => true],
                ],
            ],
            [
                'question' => 'Is Ola an Indian ride-hailing company?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which of these is an Indian food delivery company?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Swiggy', 'correct' => true],
                    ['text' => 'Uber Eats', 'correct' => false],
                    ['text' => 'DoorDash', 'correct' => false],
                    ['text' => 'Grubhub', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian jewelry brands:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 20,
                'options' => [
                    ['text' => 'Tanishq', 'correct' => true],
                    ['text' => 'CaratLane', 'correct' => true],
                    ['text' => 'Kay Jewelers', 'correct' => false],
                    ['text' => 'Malabar Gold', 'correct' => true],
                ],
            ],
            [
                'question' => 'Is FirstCry an Indian baby products company?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which of these is an Indian fintech company?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => 'Paytm', 'correct' => true],
                    ['text' => 'PayPal', 'correct' => false],
                    ['text' => 'Square', 'correct' => false],
                    ['text' => 'Stripe', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian automobile manufacturers:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 20,
                'options' => [
                    ['text' => 'Tata Motors', 'correct' => true],
                    ['text' => 'Mahindra', 'correct' => true],
                    ['text' => 'Hyundai', 'correct' => false],
                    ['text' => 'Maruti Suzuki', 'correct' => true],
                ],
            ],
            [
                'question' => 'Is Big Bazaar an Indian retail chain?',
                'type' => 'true_false',
                'difficulty' => 'easy',
                'points' => 10,
                'options' => [
                    ['text' => 'True', 'correct' => true],
                    ['text' => 'False', 'correct' => false],
                ],
            ],
            [
                'question' => 'Which of these is an Indian online pharmacy?',
                'type' => 'mcq',
                'difficulty' => 'medium',
                'points' => 15,
                'options' => [
                    ['text' => '1mg', 'correct' => true],
                    ['text' => 'CVS', 'correct' => false],
                    ['text' => 'Walgreens', 'correct' => false],
                    ['text' => 'Boots', 'correct' => false],
                ],
            ],
            [
                'question' => 'Select all Indian electronics brands:',
                'type' => 'multi_select',
                'difficulty' => 'medium',
                'points' => 20,
                'options' => [
                    ['text' => 'Micromax', 'correct' => true],
                    ['text' => 'Lava', 'correct' => true],
                    ['text' => 'Samsung', 'correct' => false],
                    ['text' => 'Intex', 'correct' => true],
                ],
            ],
        ];

        foreach ($questions as $questionData) {
            $question = GameQuestion::create([
                'game_id' => $game->id,
                'question' => $questionData['question'],
                'type' => $questionData['type'],
                'difficulty' => $questionData['difficulty'],
                'points' => $questionData['points'],
            ]);

            foreach ($questionData['options'] as $index => $optionData) {
                GameOption::create([
                    'question_id' => $question->id,
                    'option_text' => $optionData['text'],
                    'optionable_id' => null,
                    'optionable_type' => null,
                    'is_correct' => $optionData['correct'],
                    'sort_order' => $index + 1,
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
