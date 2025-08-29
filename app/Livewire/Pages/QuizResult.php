<?php

namespace App\Livewire\Pages;

use App\Models\Game;
use App\Models\GameResult;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout as LayoutAttr;
use Livewire\Component;

#[LayoutAttr('components.layouts.app')]
class QuizResult extends Component
{
    public $result;

    public Game $game;

    public int $userRank = 0;

    public int $totalParticipants = 0;

    public bool $showCertificateModal = false;

    protected array $optionTextById = [];

    public function mount(int|string $result): void
    {
        $this->result = GameResult::with([
            'game',
            'user',
            'resultQuestions.answers.option',
            'resultQuestions.answers.option.optionable',
        ])->findOrFail($result);
        $this->game = $this->result->game;

        $this->buildOptionTextMap();
        $this->calculateRankAndParticipants();
    }

    public function showCertificate(): void
    {
        $this->showCertificateModal = true;
    }

    public function closeCertificateModal(): void
    {
        $this->showCertificateModal = false;
    }

    public function downloadCertificate(): void
    {
        $this->result->generateCertificateId();
        $this->dispatch('downloadCertificate', [
            'resultId' => $this->result->id,
            'certificateId' => $this->result->certificate_id,
        ]);
    }

    public function shareResult(): void
    {
        $shareText = $this->result->getSocialShareText();
        $shareUrl = $this->result->getShareUrl();

        $this->dispatch('shareResult', [
            'text' => $shareText,
            'url' => $shareUrl,
        ]);
    }

    public function playAgain()
    {
        if ($this->game->canUserPlay(Auth::id())) {
            return redirect()->route('quiz.start', ['game' => $this->game->id]);
        } else {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => __('messages.cannot_replay'),
            ]);
        }
    }

    public function backToQuizzes()
    {
        return redirect()->route('quiz');
    }

    public function viewProfile()
    {
        return redirect()->route('user.profile', ['activeTab' => 'history']);
    }

    public function getPerformanceGradeProperty(): string
    {
        return $this->result->getPerformanceGrade();
    }

    public function getPerformanceColorProperty(): string
    {
        return $this->result->getPerformanceColor();
    }

    public function getFormattedTimeTakenProperty(): string
    {
        return $this->result->getFormattedTimeTaken();
    }

    public function getSocialShareTextProperty(): string
    {
        return $this->result->getSocialShareText();
    }

    public function getQuestionBreakdownProperty(): array
    {
        return $this->result->question_details ?? [];
    }

    public function getEnrichedQuestionBreakdownProperty(): array
    {
        $showCorrect = (bool) ($this->game->show_correct_answers ?? true);
        $questionDetails = $this->result->question_details ?? [];

        // Enhanced approach: Use both question_details and normalized data
        return collect($questionDetails)->map(function (array $question) use ($showCorrect): array {
            $userAnswerIds = (array) ($question['user_answers'] ?? []);
            $correctAnswerIds = (array) ($question['correct_answers'] ?? []);

            // Try to get answer texts from multiple sources
            $userAnswerTexts = $this->getAnswerTexts($userAnswerIds, $question['question_id'], 'user');
            $correctAnswerTexts = $showCorrect
                ? $this->getAnswerTexts($correctAnswerIds, $question['question_id'], 'correct')
                : [];

            // Handle case where user didn't answer
            $userAnswered = ! empty($userAnswerIds);
            $userAnswerDisplay = $userAnswered ? $userAnswerTexts : [__('messages.no_answer_selected')];

            return [
                'question_id' => (int) ($question['question_id'] ?? 0),
                'question_text' => (string) ($question['question_text'] ?? ''),
                'points' => (int) ($question['points'] ?? 0),
                'earned_points' => (int) ($question['earned_points'] ?? 0),
                'is_correct' => (bool) ($question['is_correct'] ?? false),
                'time_taken' => (int) ($question['time_taken'] ?? 0),
                'user_answer_texts' => $userAnswerDisplay,
                'correct_answer_texts' => $correctAnswerTexts,
                'user_answered' => $userAnswered,
            ];
        })->all();
    }

    /**
     * Get answer texts from multiple sources with fallback logic.
     */
    private function getAnswerTexts(array $answerIds, int $questionId, string $type): array
    {
        if (empty($answerIds)) {
            return [];
        }

        $answerTexts = [];

        // Method 1: Try to get from optionTextById mapping (most reliable)
        foreach ($answerIds as $optionId) {
            if (isset($this->optionTextById[$optionId])) {
                $answerTexts[] = $this->optionTextById[$optionId];
            }
        }

        // Method 2: If optionTextById didn't work, try to get from normalized data
        if (empty($answerTexts)) {
            $resultQuestion = $this->result->resultQuestions
                ->where('question_id', $questionId)
                ->first();

            if ($resultQuestion) {
                $answers = $resultQuestion->answers ?? collect();

                if ($answers->isEmpty()) {
                    $resultQuestion->load('answers.option');
                    $answers = $resultQuestion->answers ?? collect();
                }

                if ($type === 'user') {
                    $selectedAnswers = $answers->where('selected', true);
                    $answerTexts = $selectedAnswers->map(function ($answer) {
                        // If option_text is empty, try to get from the option relationship
                        if (empty($answer->option_text) && $answer->option) {
                            return $answer->option->display_text;
                        }

                        return $answer->option_text;
                    })->filter()->values()->all();
                } else {
                    $correctAnswers = $answers->where('is_correct_option', true);
                    $answerTexts = $correctAnswers->map(function ($answer) {
                        // If option_text is empty, try to get from the option relationship
                        if (empty($answer->option_text) && $answer->option) {
                            return $answer->option->display_text;
                        }

                        return $answer->option_text;
                    })->filter()->values()->all();
                }
            }
        }

        // Method 3: If still empty, try to get from the original question_details
        if (empty($answerTexts)) {
            $questionDetails = $this->result->question_details ?? [];
            $matchingDetail = collect($questionDetails)->firstWhere('question_id', $questionId);

            if ($matchingDetail) {
                if ($type === 'user') {
                    $answerTexts = (array) ($matchingDetail['user_answer_texts'] ?? []);
                } else {
                    $answerTexts = (array) ($matchingDetail['correct_answer_texts'] ?? []);
                }
            }
        }

        // Method 4: Last resort - try to get from database directly
        if (empty($answerTexts)) {
            $options = \App\Models\GameOption::whereIn('id', $answerIds)->get();
            $answerTexts = $options->pluck('display_text')->filter()->values()->all();
        }

        return $answerTexts;
    }

    public function getPerformanceMetricsProperty(): array
    {
        return $this->result->performance_metrics ?? [];
    }

    public function getCanReplayProperty(): bool
    {
        return $this->game->canUserPlay(Auth::id());
    }

    public function getReplayButtonTextProperty(): string
    {
        if (! $this->game->allow_replay) {
            return __('messages.one_time_game');
        }

        if ($this->game->max_attempts) {
            $attempts = $this->game->gameResults()->where('user_id', Auth::id())->count();
            $remaining = $this->game->max_attempts - $attempts;

            return __('messages.replay_attempts_left', ['attempts' => $remaining]);
        }

        return __('messages.play_again');
    }

    public function getReplayButtonDisabledProperty(): bool
    {
        return ! $this->canReplay;
    }

    public function render(): View
    {
        return view('livewire.pages.quiz-result');
    }

    public function getShareDataProperty(): array
    {
        $text = $this->result->getSocialShareText();
        $url = $this->result->getShareUrl();

        return [
            'text' => $text,
            'url' => $url,
        ];
    }

    public function share(string $platform): void
    {
        $payload = [
            'platform' => $platform,
            'text' => $this->shareData['text'],
            'url' => $this->shareData['url'],
        ];

        $this->dispatch('share', $payload);
    }

    /**
     * Load question options for the game and build an id-to-text map.
     */
    private function buildOptionTextMap(): void
    {
        // Load all questions and options for the game with polymorphic relationships
        $this->game->load([
            'gameQuestions.options' => function ($query) {
                $query->orderBy('sort_order');
            },
            'gameQuestions.options.optionable',
        ]);

        $this->optionTextById = [];

        // Build mapping from game questions
        foreach ($this->game->gameQuestions as $question) {
            foreach ($question->options as $option) {
                $this->optionTextById[$option->id] = $option->display_text;
            }
        }

        // Also load any missing options that might be referenced in the results
        $questionDetails = $this->result->question_details ?? [];
        $allOptionIds = collect($questionDetails)
            ->flatMap(function ($question) {
                $userAnswerIds = (array) ($question['user_answers'] ?? []);
                $correctAnswerIds = (array) ($question['correct_answers'] ?? []);

                return array_merge($userAnswerIds, $correctAnswerIds);
            })
            ->unique()
            ->filter()
            ->values()
            ->all();

        // Find any missing option IDs
        $missingOptionIds = array_diff($allOptionIds, array_keys($this->optionTextById));

        if (! empty($missingOptionIds)) {
            $missingOptions = \App\Models\GameOption::with('optionable')->whereIn('id', $missingOptionIds)->get();
            foreach ($missingOptions as $option) {
                $this->optionTextById[$option->id] = $option->display_text;
            }
        }
    }

    /**
     * Compute total participants and the user's rank.
     */
    private function calculateRankAndParticipants(): void
    {
        $this->totalParticipants = GameResult::where('game_id', $this->game->id)->count();
        $this->userRank = GameResult::where('game_id', $this->game->id)
            ->where('total_points', '>', $this->result->total_points)
            ->count() + 1;
    }
}
