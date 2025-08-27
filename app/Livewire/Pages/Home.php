<?php

namespace App\Livewire\Pages;

use App\Models\GameResult;
use App\Models\User;
use Livewire\Component;

class Home extends Component
{
    public $stats = [
        'total_participants' => 0,
        'quizzes_completed' => 0,
        'certificates_generated' => 0,
        'top_score' => 0,
        'average_score' => 0,
    ];

    public function render()
    {
        // Get real statistics from the database
        $this->stats = [
            'total_participants' => User::where(function ($q) {
                $q->has('pledges')->orHas('gameResults');
            })->count(),
            'quizzes_completed' => GameResult::count(),
            'certificates_generated' => GameResult::where('score', '>', 0)->count(),
            'top_score' => GameResult::max('score') ?? 0,
            'average_score' => round(GameResult::avg('score') ?? 0, 1),
        ];

        return view('livewire.pages.home');
    }
}
