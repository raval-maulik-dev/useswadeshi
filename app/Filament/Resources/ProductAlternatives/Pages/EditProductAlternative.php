<?php

namespace App\Filament\Resources\ProductAlternatives\Pages;

use App\Filament\Resources\ProductAlternatives\ProductAlternativeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditProductAlternative extends EditRecord
{
    protected static string $resource = ProductAlternativeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
