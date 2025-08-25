<?php

namespace App\Filament\Resources\Vendors\Schemas;

use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class VendorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required()
                    ->placeholder('Select user'),
                TextInput::make('business_name')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Enter business name'),
                Textarea::make('address')
                    ->rows(3)
                    ->placeholder('Enter business address'),
                TextInput::make('phone')
                    ->tel()
                    ->maxLength(20)
                    ->placeholder('Enter phone number'),
                TextInput::make('website')
                    ->url()
                    ->placeholder('Enter website URL'),
                Toggle::make('verified')
                    ->label('Verified Vendor')
                    ->onIcon('heroicon-s-check-circle')
                    ->offIcon('heroicon-s-x-circle')
                    ->default(false),
            ]);
    }
}
