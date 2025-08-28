<?php

namespace App\Livewire\Pages;

use App\Models\Game;
use Livewire\Component;

class Quiz extends Component
{
    public $games = [];

    public $selectedGame = null;

    public $showResultModal = false;

    public $selectedResult = null;

    public function mount()
    {
        $this->loadGames();
    }

    public function loadGames()
    {
        $this->games = Game::active()
            ->with(['gameQuestions.options', 'gameResults' => function ($query) {
                $query->where('user_id', auth()->id());
            }])
            ->get();
    }

    public function selectGame($gameId)
    {
        $this->selectedGame = Game::find($gameId);

        if (! $this->selectedGame) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Game not found!',
            ]);

            return;
        }

        // Check if user can play this game
        if (! $this->selectedGame->canUserPlay(auth()->id())) {
            if (! $this->selectedGame->allow_replay) {
                $this->showPreviousResult();

                return;
            }

            if ($this->selectedGame->max_attempts) {
                $attempts = $this->selectedGame->gameResults()->where('user_id', auth()->id())->count();
                if ($attempts >= $this->selectedGame->max_attempts) {
                    $this->showPreviousResult();

                    return;
                }
            }
        }

        // Debug: Log the selected game
        \Log::info('Selected game: '.$this->selectedGame->name.' (ID: '.$this->selectedGame->id.')');

        $this->startQuiz();
    }

    public function showPreviousResult()
    {
        $this->selectedResult = $this->selectedGame->getUserBestResult(auth()->id());
        $this->showResultModal = true;
    }

    public function closeResultModal()
    {
        $this->showResultModal = false;
        $this->selectedResult = null;
        $this->selectedGame = null;
    }

    public function replayGame()
    {
        if ($this->selectedGame && $this->selectedGame->canUserPlay(auth()->id())) {
            $this->closeResultModal();
            $this->startQuiz();
        } else {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Cannot replay this game!',
            ]);
        }
    }

    public function startQuiz()
    {
        if ($this->selectedGame) {
            // Debug: Log the redirect URL
            $redirectUrl = route('quiz.start', ['game' => $this->selectedGame->id]);
            \Log::info('Redirecting to: '.$redirectUrl);

            // Use JavaScript redirect as a fallback
            $this->dispatch('redirect', url: $redirectUrl);
        }
    }

    public function viewHistory($gameId)
    {
        return redirect()->route('user.profile', ['activeTab' => 'history']);
    }

    public function getQuestionCount($game)
    {
        if ($game->total_questions) {
            return min($game->total_questions, $game->gameQuestions->count());
        }

        return $game->gameQuestions->count();
    }

    public function getUserGameStatus($game)
    {
        $userId = auth()->id();
        $results = $game->gameResults()->where('user_id', $userId);

        if (! $game->allow_replay && $results->exists()) {
            return 'completed';
        }

        if ($game->max_attempts) {
            $attempts = $results->count();
            if ($attempts >= $game->max_attempts) {
                return 'max_attempts_reached';
            }
            if ($attempts > 0) {
                return 'attempted';
            }
        }

        if ($results->exists()) {
            return 'played';
        }

        return 'new';
    }

    public function getGameStatusText($game)
    {
        $status = $this->getUserGameStatus($game);

        switch ($status) {
            case 'completed':
                return 'Completed';
            case 'max_attempts_reached':
                return 'Max Attempts Reached';
            case 'attempted':
                return 'Attempted';
            case 'played':
                return 'Already Played';
            default:
                return 'New Game';
        }
    }

    public function getGameStatusColor($game)
    {
        $status = $this->getUserGameStatus($game);

        switch ($status) {
            case 'completed':
                return 'bg-green-100 text-green-800 border-green-200';
            case 'max_attempts_reached':
                return 'bg-red-100 text-red-800 border-red-200';
            case 'attempted':
                return 'bg-yellow-100 text-yellow-800 border-yellow-200';
            case 'played':
                return 'bg-blue-100 text-blue-800 border-blue-200';
            default:
                return 'bg-gray-100 text-gray-800 border-gray-200';
        }
    }

    public function getGameStatusIcon($game)
    {
        $status = $this->getUserGameStatus($game);

        switch ($status) {
            case 'completed':
                return 'check-circle';
            case 'max_attempts_reached':
                return 'x-circle';
            case 'attempted':
                return 'clock';
            case 'played':
                return 'play';
            default:
                return 'plus-circle';
        }
    }

    public function canReplayGame($game)
    {
        if (! $game->allow_replay) {
            return false;
        }

        if ($game->max_attempts) {
            $attempts = $game->gameResults()->where('user_id', auth()->id())->count();

            return $attempts < $game->max_attempts;
        }

        return true;
    }

    public function render()
    {
        return view('livewire.pages.quiz')
            ->layout('components.layouts.app');
    }
}
