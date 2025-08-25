<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Enter full name'),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->unique(ignoreRecord: true)
                    ->required()
                    ->placeholder('Enter email address'),
                TextInput::make('phone')
                    ->tel()
                    ->maxLength(20)
                    ->placeholder('Enter phone number'),
                Toggle::make('email_verified_at')
                    ->label('Email Verified')
                    ->onIcon('heroicon-s-check-circle')
                    ->offIcon('heroicon-s-x-circle'),
                Select::make('role')
                    ->options([
                        'user' => 'User',
                        'vendor' => 'Vendor',
                        'admin' => 'Admin'
                    ])
                    ->default('user')
                    ->required()
                    ->searchable(),
                TextInput::make('password')
                    ->password()
                    ->required(fn (string $context): bool => $context === 'create')
                    ->minLength(8)
                    ->confirmed()
                    ->placeholder('Enter password'),
                TextInput::make('password_confirmation')
                    ->password()
                    ->required(fn (string $context): bool => $context === 'create')
                    ->placeholder('Confirm password'),
            ]);
    }
}
