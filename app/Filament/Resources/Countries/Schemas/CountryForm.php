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
                    ->required()
                    ->maxLength(255),
                TextInput::make('code')
                    ->required()
                    ->maxLength(2)
                    ->minLength(2)
                    ->regex('/^[A-Z]{2}$/')
                    ->unique(ignoreRecord: true),
                TextInput::make('phone_code')
                    ->maxLength(10),
                TextInput::make('currency')
                    ->maxLength(10),
                TextInput::make('currency_symbol')
                    ->maxLength(5),
            ]);
    }
}
