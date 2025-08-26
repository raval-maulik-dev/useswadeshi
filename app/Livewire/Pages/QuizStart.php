<?php

namespace App\Livewire\Pages;

use App\Models\Game;
use App\Models\GameResult;
use Livewire\Component;

class QuizStart extends Component
{
    public $game;

    public $questions = [];

    public $currentQuestionIndex = 0;

    public $userAnswers = [];

    public $timeLeft = 10;

    public $isQuizComplete = false;

    public $score = 0;

    public $totalQuestions = 0;

    public $isLoading = false;

    public function mount($game)
    {
        $this->game = Game::with('gameQuestions')->findOrFail($game);
        $this->questions = $this->game->gameQuestions->shuffle()->take(20);
        $this->totalQuestions = $this->questions->count();
        $this->userAnswers = array_fill(0, $this->totalQuestions, null);
        $this->startTimer();
    }

    public function startTimer()
    {
        $this->timeLeft = 10;
        $this->dispatch('startTimer', timeLeft: $this->timeLeft);
    }

    public function answerQuestion($answer)
    {
        $this->userAnswers[$this->currentQuestionIndex] = $answer;

        if ($this->currentQuestionIndex < $this->totalQuestions - 1) {
            $this->currentQuestionIndex++;
            $this->startTimer();
        } else {
            $this->completeQuiz();
        }
    }

    public function completeQuiz()
    {
        $this->isLoading = true;

        // Calculate score
        $correctAnswers = 0;
        foreach ($this->questions as $index => $question) {
            if ($this->userAnswers[$index] === $question->correct_answer) {
                $correctAnswers++;
            }
        }

        $this->score = $correctAnswers;

        // Save result
        GameResult::create([
            'user_id' => auth()->id(),
            'game_id' => $this->game->id,
            'score' => $this->score,
            'total_questions' => $this->totalQuestions,
            'answers' => $this->userAnswers,
        ]);

        $this->isQuizComplete = true;
        $this->isLoading = false;

        return redirect()->route('quiz.result', [
            'score' => $this->score,
            'total' => $this->totalQuestions,
            'game' => $this->game->id,
        ]);
    }

    public function render()
    {
        return view('livewire.pages.quiz-start')
            ->layout('components.layouts.app');
    }
}
