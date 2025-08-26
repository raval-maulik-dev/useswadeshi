<?php

namespace App\Livewire\Pages;

use App\Models\Game;
use Livewire\Component;

class Quiz extends Component
{
    public $games = [];

    public $selectedGame = null;

    public function mount()
    {
        $this->games = Game::with('gameQuestions')->get();
    }

    public function selectGame($gameId)
    {
        $this->selectedGame = Game::find($gameId);
        $this->startQuiz();
    }

    public function startQuiz()
    {
        if ($this->selectedGame) {
            return redirect()->route('quiz.start', ['game' => $this->selectedGame->id]);
        }
    }

    public function render()
    {
        return view('livewire.pages.quiz')
            ->layout('components.layouts.app');
    }
}
