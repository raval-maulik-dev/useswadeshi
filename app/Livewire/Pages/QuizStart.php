<?php

namespace App\Livewire\Pages;

use App\Models\Game;
use App\Models\GameResult;
use App\Models\GameResultAnswer;
use App\Models\GameResultQuestion;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout as LayoutAttr;
use Livewire\Component;

#[LayoutAttr('components.layouts.app')]
class QuizStart extends Component
{
    public Game $game;

    public Collection $questions;

    public bool $isLoading = false;

    public bool $isQuizComplete = false;

    // Quiz configuration
    public int $totalQuestions = 0;

    public int $perQuestionTime = 15;

    public string $startTime;

    public function mount($game): void
    {
        $this->game = $game;

        // Validate game access
        if (! $this->game->canUserPlay(Auth::id())) {
            $this->redirectRoute('quiz');

            return;
        }

        // Load and prepare questions
        $this->initializeQuiz();
    }

    private function initializeQuiz(): void
    {
        // Get questions with eager loading to prevent N+1 queries
        $this->questions = $this->game->gameQuestions()
            ->with([
                'options' => function ($query) {
                    $query->orderBy('sort_order');
                },
                'options.optionable',
                'correctOptions' => function ($query) {
                    $query->orderBy('sort_order');
                },
                'correctOptions.optionable',
            ])
            ->inRandomOrder()
            ->limit($this->game->total_questions)
            ->get();

        $this->totalQuestions = $this->questions->count();

        if ($this->totalQuestions === 0) {
            $this->redirectRoute('quiz');

            return;
        }

        // Shuffle options for each question
        foreach ($this->questions as $question) {
            $question->setRelation('options', $question->options->shuffle());
        }

        $this->perQuestionTime = $this->game->per_question_time ?: $this->perQuestionTime;
        $this->startTime = now()->toISOString();
    }

    /**
     * Single endpoint to submit all quiz results
     * This reduces server calls from potentially hundreds to just one
     */
    public function submitQuizResults(array $payload)
    {
        try {
            $this->isLoading = true;

            // Validate payload structure
            $answers = $payload['answers'] ?? [];
            $questionTimes = $payload['questionTimes'] ?? [];
            $totalTimeTaken = $payload['totalTimeTaken'] ?? 0;

            // Calculate results
            $results = $this->calculateResults($answers, $questionTimes);

            // Save result
            $result = $this->saveResult($results, $totalTimeTaken);

            $this->isQuizComplete = true;
            $this->isLoading = false;

            return $this->redirectRoute('quiz.result', ['result' => $result->id]);

        } catch (\Exception $e) {
            $this->isLoading = false;
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'An error occurred while processing your results. Please try again.',
            ]);
        }
    }

    private function calculateResults(array $answers, array $questionTimes): array
    {
        $correctAnswers = 0;
        $totalPoints = 0;
        $maxPossiblePoints = 0;
        $questionDetails = [];

        foreach ($this->questions as $index => $question) {
            $userAnswerIds = $answers[$index] ?? [];
            $correctOptionIds = $question->correctOptions->pluck('id')->toArray();
            $optionTextById = $question->options->mapWithKeys(fn ($o) => [$o->id => $o->display_text])->toArray();
            $maxPossiblePoints += $question->points;

            $questionDetail = [
                'question_id' => $question->id,
                'question_text' => $question->question,
                'user_answers' => $userAnswerIds,
                'correct_answers' => $correctOptionIds,
                'time_taken' => $questionTimes[$index] ?? 0,
                'points' => $question->points,
                'is_correct' => false,
                'earned_points' => 0,
                // Precomputed texts for robust rendering
                'user_answer_texts' => collect((array) $userAnswerIds)
                    ->map(fn ($id) => $optionTextById[$id] ?? null)
                    ->filter()
                    ->values()
                    ->all(),
                'correct_answer_texts' => collect((array) $correctOptionIds)
                    ->map(fn ($id) => $optionTextById[$id] ?? null)
                    ->filter()
                    ->values()
                    ->all(),
            ];

            // Check if answer is correct
            if ($this->isAnswerCorrect($question, $userAnswerIds, $correctOptionIds)) {
                $correctAnswers++;
                $totalPoints += $question->points;
                $questionDetail['is_correct'] = true;
                $questionDetail['earned_points'] = $question->points;
            }

            $questionDetails[] = $questionDetail;
        }

        return [
            'correctAnswers' => $correctAnswers,
            'incorrectAnswers' => $this->totalQuestions - $correctAnswers,
            'totalPoints' => $totalPoints,
            'maxPossiblePoints' => $maxPossiblePoints,
            'questionDetails' => $questionDetails,
        ];
    }

    private function isAnswerCorrect($question, array $userAnswerIds, array $correctOptionIds): bool
    {
        if ($question->type === 'multi_select') {
            // For multi-select: all correct answers must be selected and no incorrect ones
            $userCorrect = count(array_intersect($userAnswerIds, $correctOptionIds));
            $userIncorrect = count(array_diff($userAnswerIds, $correctOptionIds));
            $totalCorrect = count($correctOptionIds);

            return $userCorrect === $totalCorrect && $userIncorrect === 0;
        } else {
            // For single answer questions
            return count($userAnswerIds) === 1 && in_array($userAnswerIds[0], $correctOptionIds);
        }
    }

    private function saveResult(array $results, int $totalTimeTaken): GameResult
    {
        $accuracyPercentage = $this->totalQuestions > 0
            ? round(($results['correctAnswers'] / $this->totalQuestions) * 100, 2)
            : 0;

        $attemptNumber = $this->game->getUserAttemptNumber(Auth::id());

        $result = GameResult::create([
            'user_id' => Auth::id(),
            'game_id' => $this->game->id,
            'score' => $results['correctAnswers'],
            'total_questions' => $this->totalQuestions,
            'answers' => $results['questionDetails'],
            'total_points' => $results['totalPoints'],
            'max_possible_points' => $results['maxPossiblePoints'],
            'correct_answers' => $results['correctAnswers'],
            'incorrect_answers' => $results['incorrectAnswers'],
            'time_taken' => $totalTimeTaken,
            'accuracy_percentage' => $accuracyPercentage,
            'attempt_number' => $attemptNumber,
            'question_details' => $results['questionDetails'],
            'performance_metrics' => [
                'average_time_per_question' => $this->totalQuestions > 0 ? round($totalTimeTaken / $this->totalQuestions, 2) : 0,
                'questions_answered' => count(array_filter($results['questionDetails'], fn ($q) => ! empty($q['user_answers']))),
            ],
            'device_info' => request()->header('User-Agent'),
            'ip_address' => request()->ip(),
        ]);

        // Persist normalized per-question rows and answers for scalability
        foreach ($results['questionDetails'] as $index => $qd) {
            $question = $this->questions[$index] ?? null;
            if (! $question) {
                continue;
            }

            $rq = GameResultQuestion::create([
                'game_result_id' => $result->id,
                'question_id' => $question->id,
                'question_text' => $question->question,
                'points' => (int) ($qd['points'] ?? $question->points ?? 0),
                'is_correct' => (bool) ($qd['is_correct'] ?? false),
                'earned_points' => (int) ($qd['earned_points'] ?? 0),
                'time_taken' => (int) ($qd['time_taken'] ?? 0),
            ]);

            $optionTextById = $question->options->mapWithKeys(fn ($o) => [$o->id => $o->display_text])->toArray();

            $userIds = (array) ($qd['user_answers'] ?? []);
            foreach ($userIds as $oid) {
                GameResultAnswer::create([
                    'game_result_question_id' => $rq->id,
                    'option_id' => $oid,
                    'option_text' => $optionTextById[$oid] ?? '',
                    'is_correct_option' => in_array($oid, (array) ($qd['correct_answers'] ?? []), true),
                    'selected' => true,
                ]);
            }

            // Also persist correct options snapshot not chosen by user (for full correctness audit)
            foreach ((array) ($qd['correct_answers'] ?? []) as $oid) {
                if (! in_array($oid, $userIds, true)) {
                    GameResultAnswer::create([
                        'game_result_question_id' => $rq->id,
                        'option_id' => $oid,
                        'option_text' => $optionTextById[$oid] ?? '',
                        'is_correct_option' => true,
                        'selected' => false,
                    ]);
                }
            }
        }

        return $result;
    }

    public function render(): mixed
    {
        return view('livewire.pages.quiz-start');
    }

    /**
     * Prepare questions data for frontend consumption
     */
    public function getQuestionsData(): array
    {
        return $this->questions->map(function ($question) {
            return [
                'id' => $question->id,
                'question' => $question->question,
                'type' => $question->type,
                'difficulty' => $question->difficulty,
                'points' => $question->points,
                'options' => $question->options->map(function ($option) {
                    return [
                        'id' => $option->id,
                        'option_text' => $option->display_text,
                        'optionable_type' => $option->optionable_type,
                        'optionable' => $option->optionable ? [
                            'name' => $option->optionable->name,
                            'type' => $option->optionable_type,
                        ] : null,
                    ];
                }),
            ];
        })->toArray();
    }
}
