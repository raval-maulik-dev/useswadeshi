<?php

namespace App\Filament\Resources\Pledges\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PledgeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Select::make('product_id')
                    ->relationship('product', 'name'),
                Textarea::make('message')
                    ->columnSpanFull(),
                TextInput::make('certificate_url'),
            ]);
    }
}
