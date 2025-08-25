<?php

namespace App\Filament\Resources\Vendors\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class VendorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Textarea::make('description')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                FileUpload::make('logo')
                    ->image()
                    ->directory('vendors'),
                TextInput::make('website')
                    ->url()
                    ->maxLength(255),
                TextInput::make('contact_email')
                    ->email()
                    ->maxLength(255),
                TextInput::make('contact_phone')
                    ->tel()
                    ->maxLength(255),
            ]);
    }
}
