<?php

namespace App\Filament\Resources\Users\Schemas;


use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Basic Information')
                    ->description('User account and contact information')
                    ->components([
                        Grid::make(2)
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
                            ]),

                        Grid::make(2)
                            ->components([
                                TextInput::make('phone')
                                    ->tel()
                                    ->maxLength(20)
                                    ->placeholder('Enter phone number'),

                                Select::make('role')
                                    ->options([
                                        'user' => 'User',
                                        'vendor' => 'Vendor',
                                        'admin' => 'Admin',
                                    ])
                                    ->default('user')
                                    ->required()
                                    ->searchable(),
                            ]),
                    ]),

                Section::make('Location Information')
                    ->description('User location and address details')
                    ->collapsible()
                    ->collapsed()
                    ->components([
                        Grid::make(3)
                            ->components([
                                TextInput::make('city')
                                    ->maxLength(255)
                                    ->placeholder('Enter city'),

                                TextInput::make('state')
                                    ->maxLength(255)
                                    ->placeholder('Enter state/province'),

                                TextInput::make('country')
                                    ->maxLength(255)
                                    ->placeholder('Enter country'),
                            ]),
                    ]),

                Section::make('Account Settings')
                    ->description('Account verification and security settings')
                    ->collapsible()
                    ->collapsed()
                    ->components([
                        Grid::make(2)
                            ->components([
                                Toggle::make('email_verified_at')
                                    ->label('Email Verified')
                                    ->onIcon('heroicon-s-check-circle')
                                    ->offIcon('heroicon-s-x-circle'),

                                TextInput::make('password')
                                    ->password()
                                    ->required(fn (string $context): bool => $context === 'create')
                                    ->minLength(8)
                                    ->confirmed()
                                    ->placeholder('Enter password'),
                            ]),

                        TextInput::make('password_confirmation')
                            ->password()
                            ->required(fn (string $context): bool => $context === 'create')
                            ->placeholder('Confirm password')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
