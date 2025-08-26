<?php

namespace App\Livewire\Pages;

use App\Models\GameResult;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Leaderboard extends Component
{
    use WithPagination;

    public $topPerformers = [];

    public $recentResults = [];

    public $stats = [];

    public function mount()
    {
        $this->loadLeaderboardData();
    }

    public function loadLeaderboardData()
    {
        // Top 10 performers
        $this->topPerformers = GameResult::with('user')
            ->select('user_id', \DB::raw('MAX(score) as best_score'), \DB::raw('COUNT(*) as attempts'))
            ->groupBy('user_id')
            ->orderBy('best_score', 'desc')
            ->orderBy('attempts', 'asc')
            ->limit(10)
            ->get()
            ->map(function ($result) {
                $result->user_name = $result->user->name;

                return $result;
            });

        // Recent results
        $this->recentResults = GameResult::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        // Statistics
        $this->stats = [
            'total_participants' => User::count(),
            'total_quizzes' => GameResult::count(),
            'average_score' => round(GameResult::avg('score') ?? 0, 1),
            'highest_score' => GameResult::max('score') ?? 0,
        ];
    }

    public function render()
    {
        return view('livewire.pages.leaderboard')
            ->layout('components.layouts.app');
    }
}
