<?php

namespace App\Filament\Resources\ProductAlternatives\Pages;

use App\Filament\Resources\ProductAlternatives\ProductAlternativeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListProductAlternatives extends ListRecords
{
    protected static string $resource = ProductAlternativeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
