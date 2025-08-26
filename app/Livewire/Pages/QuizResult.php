<?php

namespace App\Livewire\Pages;

use App\Models\Game;
use App\Models\GameResult;
use Livewire\Component;

class QuizResult extends Component
{
    public $score = 0;

    public $totalQuestions = 0;

    public $percentage = 0;

    public $game;

    public $userRank = 0;

    public $totalParticipants = 0;

    public function mount($score, $total, $game)
    {
        $this->score = $score;
        $this->totalQuestions = $total;
        $this->percentage = round(($score / $total) * 100, 1);
        $this->game = Game::find($game);

        // Calculate user rank
        $this->totalParticipants = GameResult::where('game_id', $game)->count();
        $this->userRank = GameResult::where('game_id', $game)
            ->where('score', '>', $score)
            ->count() + 1;
    }

    public function shareResult()
    {
        $message = "I scored {$this->score}/{$this->totalQuestions} ({$this->percentage}%) on the Swadeshi Abhiyan Quiz! 🏆 #UseSwadeshi #SwadeshiAbhiyan #VocalForLocal";

        // This would integrate with social media sharing APIs
        $this->dispatch('shareResult', message: $message);
    }

    public function downloadCertificate()
    {
        // This would generate and download a PDF certificate
        $this->dispatch('downloadCertificate', score: $this->score, total: $this->totalQuestions);
    }

    public function render()
    {
        return view('livewire.pages.quiz-result')
            ->layout('components.layouts.app');
    }
}
