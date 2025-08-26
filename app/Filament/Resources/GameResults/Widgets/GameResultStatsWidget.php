<?php

namespace App\Filament\Resources\GameResults\Widgets;

use App\Models\Game;
use App\Models\GameResult;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class GameResultStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalResults = GameResult::count();
        $totalUsers = User::has('gameResults')->count();
        $totalGames = Game::has('gameResults')->count();
        $averageAccuracy = GameResult::avg('accuracy_percentage');
        $certificatesGenerated = GameResult::whereNotNull('certificate_id')->count();
        $recentResults = GameResult::where('created_at', '>=', now()->subDays(7))->count();

        return [
            Stat::make('Total Quiz Attempts', $totalResults)
                ->description('All quiz attempts by users')
                ->descriptionIcon('heroicon-m-trophy')
                ->color('primary'),

            Stat::make('Active Users', $totalUsers)
                ->description('Users who have taken quizzes')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success'),

            Stat::make('Games Played', $totalGames)
                ->description('Games that have been attempted')
                ->descriptionIcon('heroicon-m-play')
                ->color('info'),

            Stat::make('Average Accuracy', number_format($averageAccuracy, 1).'%')
                ->description('Overall user performance')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('warning'),

            Stat::make('Certificates Generated', $certificatesGenerated)
                ->description('Certificates issued to users')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('secondary'),

            Stat::make('Recent Attempts (7 days)', $recentResults)
                ->description('Quiz attempts in the last week')
                ->descriptionIcon('heroicon-m-clock')
                ->color('success'),
        ];
    }
}
