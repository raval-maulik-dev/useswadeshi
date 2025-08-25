<?php

namespace App\Filament\Resources\Countries\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CountryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Country Name')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->placeholder('Enter country name'),
                TextInput::make('iso_code')
                    ->label('ISO Code')
                    ->required()
                    ->maxLength(3)
                    ->unique(ignoreRecord: true)
                    ->uppercase()
                    ->placeholder('Enter ISO code (e.g., IND)'),
            ]);
    }
}
