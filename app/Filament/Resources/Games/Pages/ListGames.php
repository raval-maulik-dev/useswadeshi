<?php

namespace App\Filament\Resources\Games\Pages;

use App\Filament\Resources\Games\GameResource;
use App\Filament\Resources\Games\Widgets\GameStatsWidget;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGames extends ListRecords
{
    protected static string $resource = GameResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            GameStatsWidget::class,
        ];
    }
}
