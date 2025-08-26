<?php

namespace App\Filament\Resources\Games\Widgets;

use App\Models\Game;
use App\Models\GameResult;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class GameStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalGames = Game::count();
        $activeGames = Game::where('is_active', true)->count();
        $totalQuestions = \App\Models\GameQuestion::count();
        $totalResults = GameResult::count();
        $totalUsers = User::count();
        $activeUsers = User::has('gameResults')->count();

        return [
            Stat::make('Total Games', $totalGames)
                ->description('All games in the system')
                ->descriptionIcon('heroicon-m-play')
                ->color('primary'),

            Stat::make('Active Games', $activeGames)
                ->description('Currently playable games')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Total Questions', $totalQuestions)
                ->description('Questions across all games')
                ->descriptionIcon('heroicon-m-question-mark-circle')
                ->color('info'),

            Stat::make('Total Quiz Attempts', $totalResults)
                ->description('All quiz attempts by users')
                ->descriptionIcon('heroicon-m-trophy')
                ->color('warning'),

            Stat::make('Total Users', $totalUsers)
                ->description('Registered users')
                ->descriptionIcon('heroicon-m-users')
                ->color('secondary'),

            Stat::make('Active Users', $activeUsers)
                ->description('Users who have taken quizzes')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success'),
        ];
    }
}
