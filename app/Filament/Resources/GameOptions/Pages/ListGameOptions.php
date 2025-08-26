<?php

namespace App\Filament\Resources\GameOptions\Pages;

use App\Filament\Resources\GameOptions\GameOptionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGameOptions extends ListRecords
{
    protected static string $resource = GameOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
