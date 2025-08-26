<?php

namespace App\Filament\Resources\GameResults\Pages;

use App\Filament\Resources\GameResults\GameResultResource;
use App\Filament\Resources\GameResults\Widgets\GameResultStatsWidget;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGameResults extends ListRecords
{
    protected static string $resource = GameResultResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            GameResultStatsWidget::class,
        ];
    }
}
