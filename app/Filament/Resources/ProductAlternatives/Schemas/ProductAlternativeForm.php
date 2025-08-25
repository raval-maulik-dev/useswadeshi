<?php

namespace App\Filament\Resources\ProductAlternatives\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProductAlternativeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('foreign_product_id')
                    ->relationship('foreignProduct', 'name')
                    ->required(),
                Select::make('local_product_id')
                    ->relationship('localProduct', 'name')
                    ->required(),
                TextInput::make('note'),
            ]);
    }
}
