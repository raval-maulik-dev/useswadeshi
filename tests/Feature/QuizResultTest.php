<?php

namespace Tests\Feature;

use App\Models\Game;
use App\Models\GameOption;
use App\Models\GameQuestion;
use App\Models\GameResult;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class QuizResultTest extends TestCase
{
    use RefreshDatabase;

    public function test_debug_option_mapping(): void
    {
        // Create a user
        $user = User::factory()->create();

        // Create a game
        $game = Game::factory()->create([
            'show_correct_answers' => true,
        ]);

        // Create a question with options
        $question = GameQuestion::factory()->create([
            'game_id' => $game->id,
            'question' => 'Is Amul an Indian dairy brand?',
            'type' => 'single_select',
            'points' => 5,
        ]);

        $correctOption = GameOption::factory()->text('Yes')->correct()->create([
            'question_id' => $question->id,
        ]);

        $incorrectOption = GameOption::factory()->text('No')->incorrect()->create([
            'question_id' => $question->id,
        ]);

        // Debug: Check if options were created
        $this->assertNotNull($correctOption->id, 'Correct option ID is null');
        $this->assertNotNull($incorrectOption->id, 'Incorrect option ID is null');
        $this->assertEquals('Yes', $correctOption->option_text, 'Correct option text is wrong');
        $this->assertEquals('No', $incorrectOption->option_text, 'Incorrect option text is wrong');

        // Debug: Check if options are in database
        $optionsFromDb = GameOption::where('question_id', $question->id)->get();
        $this->assertCount(2, $optionsFromDb, 'Should have 2 options in database');

        $optionIds = $optionsFromDb->pluck('id')->toArray();
        $this->assertContains($correctOption->id, $optionIds, 'Correct option not found in database');
        $this->assertContains($incorrectOption->id, $optionIds, 'Incorrect option not found in database');

        // Build option text map manually
        $game->load([
            'gameQuestions.options' => function ($query) {
                $query->orderBy('sort_order');
            },
        ]);

        // Debug: Check what questions and options are loaded
        $this->assertCount(1, $game->gameQuestions, 'Game should have 1 question');

        $loadedQuestion = $game->gameQuestions->first();
        $loadedOptions = $loadedQuestion->options;

        $this->assertCount(2, $loadedOptions, 'Question should have 2 options');

        // Debug: Check what options are actually loaded
        $loadedOptionIds = $loadedOptions->pluck('id')->toArray();
        $this->assertContains($correctOption->id, $loadedOptionIds, 'Correct option not loaded through relationship');
        $this->assertContains($incorrectOption->id, $loadedOptionIds, 'Incorrect option not loaded through relationship');

        $optionTextById = [];

        foreach ($game->gameQuestions as $question) {
            foreach ($question->options as $option) {
                $optionTextById[$option->id] = $option->option_text;
            }
        }

        // Debug: Check option mapping
        $this->assertNotEmpty($optionTextById, 'optionTextById is empty');
        $this->assertArrayHasKey($correctOption->id, $optionTextById, 'Correct option not found in mapping');
        $this->assertArrayHasKey($incorrectOption->id, $optionTextById, 'Incorrect option not found in mapping');
        $this->assertEquals('Yes', $optionTextById[$correctOption->id], 'Correct option text not mapped correctly');
        $this->assertEquals('No', $optionTextById[$incorrectOption->id], 'Incorrect option text not mapped correctly');

        // Test the logic directly
        $questionDetails = [
            [
                'question_id' => $question->id,
                'question_text' => 'Is Amul an Indian dairy brand?',
                'user_answers' => [$incorrectOption->id], // User selected wrong answer
                'correct_answers' => [$correctOption->id],
                'points' => 5,
                'is_correct' => false,
                'earned_points' => 0,
                'time_taken' => 5,
            ],
        ];

        $showCorrect = true;
        $enrichedBreakdown = collect($questionDetails)->map(function (array $question) use ($showCorrect, $optionTextById): array {
            $userAnswerIds = (array) ($question['user_answers'] ?? []);
            $correctAnswerIds = (array) ($question['correct_answers'] ?? []);

            // Get user answer texts from option mapping
            $userAnswerTexts = collect($userAnswerIds)
                ->map(fn ($id) => $optionTextById[$id] ?? null)
                ->filter()
                ->values()
                ->all();

            // Get correct answer texts from option mapping (if show_correct_answers is enabled)
            $correctAnswerTexts = $showCorrect
                ? collect($correctAnswerIds)
                    ->map(fn ($id) => $optionTextById[$id] ?? null)
                    ->filter()
                    ->values()
                    ->all()
                : [];

            return [
                'question_id' => (int) ($question['question_id'] ?? 0),
                'question_text' => (string) ($question['question_text'] ?? ''),
                'points' => (int) ($question['points'] ?? 0),
                'earned_points' => (int) ($question['earned_points'] ?? 0),
                'is_correct' => (bool) ($question['is_correct'] ?? false),
                'time_taken' => (int) ($question['time_taken'] ?? 0),
                'user_answer_texts' => $userAnswerTexts,
                'correct_answer_texts' => $correctAnswerTexts,
            ];
        })->all();

        // Debug: Check enriched breakdown
        $this->assertCount(1, $enrichedBreakdown, 'enrichedBreakdown should have 1 item');

        $questionData = $enrichedBreakdown[0];
        $this->assertCount(1, $questionData['user_answer_texts'], 'user_answer_texts should have 1 item');
        $this->assertCount(1, $questionData['correct_answer_texts'], 'correct_answer_texts should have 1 item');
        $this->assertEquals('No', $questionData['user_answer_texts'][0], 'User answer text should be "No"');
        $this->assertEquals('Yes', $questionData['correct_answer_texts'][0], 'Correct answer text should be "Yes"');
    }

    public function test_livewire_component_shows_answer_texts_for_incorrect_questions(): void
    {
        // Create a user
        $user = User::factory()->create();

        // Create a game
        $game = Game::factory()->create([
            'show_correct_answers' => true,
        ]);

        // Create a question with options
        $question = GameQuestion::factory()->create([
            'game_id' => $game->id,
            'question' => 'Which brand is known for "Make in India"?',
            'type' => 'single_select',
            'points' => 10,
        ]);

        $correctOption = GameOption::factory()->text('Amul')->correct()->create([
            'question_id' => $question->id,
        ]);

        $incorrectOption = GameOption::factory()->text('Nestle')->incorrect()->create([
            'question_id' => $question->id,
        ]);

        // Create question details array
        $questionDetails = [
            [
                'question_id' => $question->id,
                'question_text' => 'Which brand is known for "Make in India"?',
                'user_answers' => [$incorrectOption->id], // User selected wrong answer
                'correct_answers' => [$correctOption->id],
                'points' => 10,
                'is_correct' => false,
                'earned_points' => 0,
                'time_taken' => 2,
            ],
        ];

        // Create a game result with explicit question_details
        $result = GameResult::create([
            'user_id' => $user->id,
            'game_id' => $game->id,
            'score' => 0,
            'total_questions' => 1,
            'answers' => [],
            'total_points' => 0,
            'max_possible_points' => 10,
            'correct_answers' => 0,
            'incorrect_answers' => 1,
            'time_taken' => 2,
            'accuracy_percentage' => 0,
            'attempt_number' => 1,
            'question_details' => $questionDetails,
            'performance_metrics' => [],
            'device_info' => 'test',
            'ip_address' => '127.0.0.1',
        ]);

        // Test the Livewire component
        $enrichedBreakdown = Livewire::actingAs($user)
            ->test(\App\Livewire\Pages\QuizResult::class, ['result' => $result->id])
            ->get('enrichedQuestionBreakdown');

        // Verify the data structure
        $this->assertCount(1, $enrichedBreakdown);

        $questionData = $enrichedBreakdown[0];
        $this->assertEquals($question->id, $questionData['question_id']);
        $this->assertEquals('Which brand is known for "Make in India"?', $questionData['question_text']);
        $this->assertFalse($questionData['is_correct']);
        $this->assertEquals(0, $questionData['earned_points']);
        $this->assertEquals(10, $questionData['points']);
        $this->assertEquals(2, $questionData['time_taken']);

        // Verify user answer texts (should show what user selected)
        $this->assertCount(1, $questionData['user_answer_texts']);
        $this->assertEquals('Nestle', $questionData['user_answer_texts'][0]);

        // Verify correct answer texts (should show what was correct)
        $this->assertCount(1, $questionData['correct_answer_texts']);
        $this->assertEquals('Amul', $questionData['correct_answer_texts'][0]);
    }
}
