<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Game;
use App\Models\GameQuestion;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class GameQuestionFormTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create a user for authentication
        $user = User::factory()->create();
        $this->actingAs($user);
    }

    public function test_can_create_game_question_with_text_options(): void
    {
        $game = Game::factory()->create();
        
        $questionData = [
            'game_id' => $game->id,
            'question' => 'What is the capital of France?',
            'type' => 'mcq',
            'difficulty' => 'medium',
            'points' => 10,
            'options' => [
                [
                    'option_type' => 'text',
                    'option_text' => 'Paris',
                    'is_correct' => true,
                    'sort_order' => 1,
                ],
                [
                    'option_type' => 'text',
                    'option_text' => 'London',
                    'is_correct' => false,
                    'sort_order' => 2,
                ],
                [
                    'option_type' => 'text',
                    'option_text' => 'Berlin',
                    'is_correct' => false,
                    'sort_order' => 3,
                ],
                [
                    'option_type' => 'text',
                    'option_text' => 'Madrid',
                    'is_correct' => false,
                    'sort_order' => 4,
                ],
            ],
        ];

        $question = GameQuestion::create([
            'game_id' => $questionData['game_id'],
            'question' => $questionData['question'],
            'type' => $questionData['type'],
            'difficulty' => $questionData['difficulty'],
            'points' => $questionData['points'],
        ]);

        // Create options
        foreach ($questionData['options'] as $optionData) {
            $question->options()->create([
                'option_text' => $optionData['option_text'],
                'is_correct' => $optionData['is_correct'],
                'sort_order' => $optionData['sort_order'],
            ]);
        }

        $this->assertDatabaseHas('game_questions', [
            'id' => $question->id,
            'question' => 'What is the capital of France?',
            'type' => 'mcq',
        ]);

        $this->assertDatabaseHas('game_options', [
            'question_id' => $question->id,
            'option_text' => 'Paris',
            'is_correct' => true,
        ]);

        $this->assertEquals(4, $question->options()->count());
        $this->assertEquals(1, $question->correctOptions()->count());
    }

    public function test_can_create_game_question_with_product_options(): void
    {
        $game = Game::factory()->create();
        $product = Product::factory()->create();
        
        $question = GameQuestion::create([
            'game_id' => $game->id,
            'question' => 'Which product is better?',
            'type' => 'mcq',
            'difficulty' => 'easy',
            'points' => 5,
        ]);

        $question->options()->create([
            'optionable_id' => $product->id,
            'optionable_type' => Product::class,
            'is_correct' => true,
            'sort_order' => 1,
        ]);

        $this->assertDatabaseHas('game_options', [
            'question_id' => $question->id,
            'optionable_id' => $product->id,
            'optionable_type' => Product::class,
            'is_correct' => true,
        ]);

        $this->assertEquals(1, $question->options()->count());
        $this->assertEquals('product', $question->options()->first()->option_type);
    }

    public function test_can_create_game_question_with_brand_options(): void
    {
        $game = Game::factory()->create();
        $brand = Brand::factory()->create();
        
        $question = GameQuestion::create([
            'game_id' => $game->id,
            'question' => 'Which brand do you prefer?',
            'type' => 'multi_select',
            'difficulty' => 'hard',
            'points' => 15,
        ]);

        $question->options()->create([
            'optionable_id' => $brand->id,
            'optionable_type' => Brand::class,
            'is_correct' => true,
            'sort_order' => 1,
        ]);

        $this->assertDatabaseHas('game_options', [
            'question_id' => $question->id,
            'optionable_id' => $brand->id,
            'optionable_type' => Brand::class,
            'is_correct' => true,
        ]);

        $this->assertEquals(1, $question->options()->count());
        $this->assertEquals('brand', $question->options()->first()->option_type);
    }

    public function test_can_edit_game_question_with_existing_options(): void
    {
        $game = Game::factory()->create();
        
        // Create a question with existing options
        $question = GameQuestion::create([
            'game_id' => $game->id,
            'question' => 'What is the best color?',
            'type' => 'mcq',
            'difficulty' => 'easy',
            'points' => 5,
        ]);

        // Create existing options
        $question->options()->createMany([
            [
                'option_text' => 'Red',
                'is_correct' => true,
                'sort_order' => 1,
            ],
            [
                'option_text' => 'Blue',
                'is_correct' => false,
                'sort_order' => 2,
            ],
            [
                'option_text' => 'Green',
                'is_correct' => false,
                'sort_order' => 3,
            ],
        ]);

        // Verify initial state
        $this->assertEquals(3, $question->options()->count());
        $this->assertEquals(1, $question->correctOptions()->count());

        // Update the question
        $question->update([
            'question' => 'What is the best color? (Updated)',
            'points' => 10,
        ]);

        // Update options
        $question->options()->delete();
        $question->options()->createMany([
            [
                'option_text' => 'Red',
                'is_correct' => true,
                'sort_order' => 1,
            ],
            [
                'option_text' => 'Blue',
                'is_correct' => false,
                'sort_order' => 2,
            ],
            [
                'option_text' => 'Green',
                'is_correct' => false,
                'sort_order' => 3,
            ],
            [
                'option_text' => 'Yellow',
                'is_correct' => false,
                'sort_order' => 4,
            ],
        ]);

        // Verify updated state
        $this->assertEquals(4, $question->options()->count());
        $this->assertEquals(1, $question->correctOptions()->count());
        $this->assertEquals(10, $question->points);
    }

    public function test_game_question_has_helpful_methods(): void
    {
        $game = Game::factory()->create();
        
        $question = GameQuestion::create([
            'game_id' => $game->id,
            'question' => 'Test question',
            'type' => 'mcq',
            'difficulty' => 'medium',
            'points' => 10,
        ]);

        $this->assertTrue($question->isSingleAnswer());
        $this->assertFalse($question->isMultipleAnswer());
        $this->assertEquals('Multiple Choice (Single Answer)', $question->type_label);
        $this->assertEquals('Medium', $question->difficulty_label);
    }

    public function test_game_option_has_helpful_methods(): void
    {
        $game = Game::factory()->create();
        $question = GameQuestion::factory()->create(['game_id' => $game->id]);
        $product = Product::factory()->create();
        
        $option = $question->options()->create([
            'optionable_id' => $product->id,
            'optionable_type' => Product::class,
            'is_correct' => true,
            'sort_order' => 1,
        ]);

        $this->assertEquals('product', $option->option_type);
        $this->assertEquals($product->name, $option->display_text);
    }
}
