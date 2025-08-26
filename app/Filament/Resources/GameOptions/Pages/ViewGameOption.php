<?php

namespace App\Filament\Resources\GameOptions\Pages;

use App\Filament\Resources\GameOptions\GameOptionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewGameOption extends ViewRecord
{
    protected static string $resource = GameOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
