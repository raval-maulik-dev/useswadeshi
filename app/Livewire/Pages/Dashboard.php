<?php

namespace App\Livewire\Pages;

use App\Models\GameResult;
use App\Models\Pledge;
use App\Models\User;
use Livewire\Component;

class Dashboard extends Component
{
    public $userStats = [];

    public $recentResults = [];

    public $userPledges = [];

    public $achievements = [];

    public function mount()
    {
        $user = auth()->user();

        // User statistics
        $this->userStats = [
            'total_quizzes' => GameResult::where('user_id', $user->id)->count(),
            'best_score' => GameResult::where('user_id', $user->id)->max('score') ?? 0,
            'average_score' => round(GameResult::where('user_id', $user->id)->avg('score') ?? 0, 1),
            'total_pledges' => Pledge::where('user_id', $user->id)->count(),
            'rank' => $this->calculateUserRank($user->id),
        ];

        // Recent quiz results
        $this->recentResults = GameResult::where('user_id', $user->id)
            ->with('game')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // User pledges
        $this->userPledges = Pledge::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Calculate achievements
        $this->achievements = $this->calculateAchievements($user->id);
    }

    private function calculateUserRank($userId)
    {
        $userBestScore = GameResult::where('user_id', $userId)->max('score') ?? 0;
        $rank = GameResult::select('user_id')
            ->selectRaw('MAX(score) as best_score')
            ->groupBy('user_id')
            ->having('best_score', '>', $userBestScore)
            ->count();

        return $rank + 1;
    }

    private function calculateAchievements($userId)
    {
        $achievements = [];

        $quizCount = GameResult::where('user_id', $userId)->count();
        $bestScore = GameResult::where('user_id', $userId)->max('score') ?? 0;
        $pledgeCount = Pledge::where('user_id', $userId)->count();

        if ($quizCount >= 1) {
            $achievements[] = ['name' => __('messages.first_quiz'), 'description' => __('messages.first_quiz_desc'), 'icon' => '🎯', 'unlocked' => true];
        }

        if ($quizCount >= 5) {
            $achievements[] = ['name' => __('messages.quiz_enthusiast'), 'description' => __('messages.quiz_enthusiast_desc'), 'icon' => '🏆', 'unlocked' => true];
        }

        if ($bestScore >= 15) {
            $achievements[] = ['name' => __('messages.high_scorer'), 'description' => __('messages.high_scorer_desc'), 'icon' => '⭐', 'unlocked' => true];
        }

        if ($pledgeCount >= 1) {
            $achievements[] = ['name' => __('messages.local_supporter'), 'description' => __('messages.local_supporter_desc'), 'icon' => '🤝', 'unlocked' => true];
        }

        return $achievements;
    }

    public function render()
    {
        return view('livewire.pages.dashboard');
    }
}
