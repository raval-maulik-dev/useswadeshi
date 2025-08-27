<?php

namespace App\Livewire\Pages;

use App\Models\Game;
use App\Models\GameResult;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Livewire\Attributes\Layout as LayoutAttr;
use Livewire\Component;

#[LayoutAttr('components.layouts.app')]
class QuizStart extends Component
{
    public $game;

    /**
     * @var \Illuminate\Support\Collection<int, \App\Models\GameQuestion>
     */
    public $questions = [];

    public $currentQuestionIndex = 0;

    public $userAnswers = [];

    public $timeLeft = 10;

    public $isQuizComplete = false;

    public $score = 0;

    public $totalQuestions = 0;

    public $isLoading = false;

    public $startTime;

    public $questionStartTime;

    public $showNextButton = false;

    public $answeredQuestions = [];

    public $questionTimes = [];

    public function mount($game)
    {
        $this->game = Game::with(['gameQuestions.options.optionable'])->findOrFail($game);

        // Check if user can play this game
        if (! $this->game->canUserPlay(Auth::id())) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'You cannot play this game!',
            ]);

            return redirect()->route('quiz');
        }

        $this->questions = collect($this->game->getQuestionsForGame());
        $this->totalQuestions = $this->questions->count();
        $this->userAnswers = array_fill(0, $this->totalQuestions, []);
        $this->answeredQuestions = array_fill(0, $this->totalQuestions, false);
        $this->questionTimes = array_fill(0, $this->totalQuestions, 0);

        $this->startTime = now();
        $this->questionStartTime = now();
    }

    public function startTimer()
    {
        if ($this->game->per_question_time) {
            $this->timeLeft = $this->game->per_question_time;
        } else {
            $this->timeLeft = 10; // Default fallback
        }

    }

    public function answerQuestion($optionId)
    {
        $currentQuestion = $this->questions[$this->currentQuestionIndex];

        if ($currentQuestion->type === 'multi_select') {
            // Handle multi-select questions
            if (! in_array($optionId, $this->userAnswers[$this->currentQuestionIndex])) {
                $this->userAnswers[$this->currentQuestionIndex][] = $optionId;
            } else {
                // Remove if already selected
                $this->userAnswers[$this->currentQuestionIndex] = array_diff($this->userAnswers[$this->currentQuestionIndex], [$optionId]);
            }
        } else {
            // Handle single answer questions (mcq, true_false)
            $this->userAnswers[$this->currentQuestionIndex] = [$optionId];
        }

        // Mark question as answered
        $this->answeredQuestions[$this->currentQuestionIndex] = true;

        // Show next button for single answer questions
        if ($currentQuestion->type !== 'multi_select') {
            $this->showNextButton = true;
        }
    }

    public function nextQuestion()
    {
        // Record time spent on current question
        $this->questionTimes[$this->currentQuestionIndex] = now()->diffInSeconds($this->questionStartTime);

        if ($this->currentQuestionIndex < $this->totalQuestions - 1) {
            $this->currentQuestionIndex++;
            $this->questionStartTime = now();
            $this->showNextButton = false;
        } else {
            $this->completeQuiz();
        }
    }

    public function previousQuestion()
    {
        if ($this->currentQuestionIndex > 0) {
            $this->currentQuestionIndex--;
            $this->questionStartTime = now();
            $this->showNextButton = false;
        }
    }

    public function completeQuiz()
    {
        $this->isLoading = true;

        // Record time for last question
        $this->questionTimes[$this->currentQuestionIndex] = now()->diffInSeconds($this->questionStartTime);

        // Calculate detailed results
        $correctAnswers = 0;
        $incorrectAnswers = 0;
        $totalPoints = 0;
        $maxPossiblePoints = 0;
        $questionDetails = [];

        foreach ($this->questions as $index => $question) {
            $userAnswerIds = $this->userAnswers[$index] ?? [];
            $correctOptionIds = $question->correctOptions->pluck('id')->toArray();
            $maxPossiblePoints += $question->points;

            $questionDetail = [
                'question_id' => $question->id,
                'question_text' => $question->question,
                'user_answers' => $userAnswerIds,
                'correct_answers' => $correctOptionIds,
                'time_taken' => $this->questionTimes[$index] ?? 0,
                'points' => $question->points,
                'is_correct' => false,
                'earned_points' => 0,
            ];

            // Check if user answers match correct answers
            if ($question->type === 'multi_select') {
                // For multi-select, all correct answers must be selected and no incorrect ones
                $userCorrect = count(array_intersect($userAnswerIds, $correctOptionIds));
                $userIncorrect = count(array_diff($userAnswerIds, $correctOptionIds));
                $totalCorrect = count($correctOptionIds);

                if ($userCorrect === $totalCorrect && $userIncorrect === 0) {
                    $correctAnswers++;
                    $totalPoints += $question->points;
                    $questionDetail['is_correct'] = true;
                    $questionDetail['earned_points'] = $question->points;
                } else {
                    $incorrectAnswers++;
                }
            } else {
                // For single answer questions
                if (count($userAnswerIds) === 1 && in_array($userAnswerIds[0], $correctOptionIds)) {
                    $correctAnswers++;
                    $totalPoints += $question->points;
                    $questionDetail['is_correct'] = true;
                    $questionDetail['earned_points'] = $question->points;
                } else {
                    $incorrectAnswers++;
                }
            }

            $questionDetails[] = $questionDetail;
        }

        $this->score = $correctAnswers;
        $accuracyPercentage = $this->totalQuestions > 0 ? round(($correctAnswers / $this->totalQuestions) * 100, 2) : 0;
        $totalTimeTaken = now()->diffInSeconds($this->startTime);

        // Get attempt number
        $attemptNumber = $this->game->getUserAttemptNumber(Auth::id());

        // Save detailed result
        $result = GameResult::create([
            'user_id' => Auth::id(),
            'game_id' => $this->game->id,
            'score' => $this->score,
            'total_questions' => $this->totalQuestions,
            'answers' => $this->userAnswers,
            'total_points' => $totalPoints,
            'max_possible_points' => $maxPossiblePoints,
            'correct_answers' => $correctAnswers,
            'incorrect_answers' => $incorrectAnswers,
            'time_taken' => $totalTimeTaken,
            'accuracy_percentage' => $accuracyPercentage,
            'attempt_number' => $attemptNumber,
            'question_details' => $questionDetails,
            'performance_metrics' => [
                'average_time_per_question' => round($totalTimeTaken / $this->totalQuestions, 2),
                'fastest_question_time' => min($this->questionTimes),
                'slowest_question_time' => max($this->questionTimes),
                'questions_answered' => count(array_filter($this->answeredQuestions)),
                'questions_skipped' => $this->totalQuestions - count(array_filter($this->answeredQuestions)),
            ],
            'device_info' => request()->header('User-Agent'),
            'ip_address' => request()->ip(),
        ]);

        $this->isQuizComplete = true;
        $this->isLoading = false;

        return redirect()->route('quiz.result', [
            'result' => $result->id,
        ]);
    }

    /**
     * Accept a single client-side submission with all answers and timings
     * to minimize server calls during the quiz.
     *
     * @param array{
     *     answers: array<int, array<int>>,
     *     questionTimes: array<int, int>,
     *     answeredQuestions: array<int, bool>
     * } $payload
     */
    public function submitResults(array $payload)
    {
        $this->userAnswers = $payload['answers'] ?? [];
        $this->questionTimes = $payload['questionTimes'] ?? [];
        $this->answeredQuestions = $payload['answeredQuestions'] ?? [];

        // Derive total time from provided per-question times to avoid extra calls
        $this->startTime = now()->subSeconds(array_sum($this->questionTimes ?? []));
        $this->questionStartTime = now();

        return $this->completeQuiz();
    }

    public function getCurrentQuestionProperty()
    {
        if ($this->questions->count() > 0 && $this->currentQuestionIndex < $this->questions->count()) {
            return $this->questions[$this->currentQuestionIndex];
        }

        return null;
    }

    public function getCurrentOptionsProperty()
    {
        if ($this->currentQuestion) {
            return $this->currentQuestion->options->sortBy('sort_order');
        }

        return collect();
    }

    public function isOptionSelected($optionId)
    {
        $userAnswers = $this->userAnswers[$this->currentQuestionIndex] ?? [];

        return in_array($optionId, $userAnswers);
    }

    public function getProgressPercentageProperty()
    {
        return round((($this->currentQuestionIndex + 1) / $this->totalQuestions) * 100);
    }

    public function getTimeLeftFormattedProperty()
    {
        if ($this->timeLeft <= 0) {
            return '00:00';
        }

        $minutes = floor($this->timeLeft / 60);
        $seconds = $this->timeLeft % 60;

        return sprintf('%02d:%02d', $minutes, $seconds);
    }

    public function getCurrentQuestionNumberProperty()
    {
        return $this->currentQuestionIndex + 1;
    }

    public function render(): mixed
    {
        return view('livewire.pages.quiz-start');
    }
}
