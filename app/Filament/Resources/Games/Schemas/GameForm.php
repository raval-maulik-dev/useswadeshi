<?php

namespace App\Filament\Resources\Games\Schemas;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class GameForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Basic Information')
                    ->description('Basic game details and description')
                    ->components([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Enter game name'),
                        Textarea::make('description')
                            ->rows(3)
                            ->placeholder('Enter game description')
                            ->columnSpanFull(),
                    ]),

                Section::make('Game Configuration')
                    ->description('Configure how the game behaves for users')
                    ->components([
                        Grid::make(2)
                            ->components([
                                TextInput::make('total_questions')
                                    ->numeric()
                                    ->minValue(1)
                                    ->maxValue(100)
                                    ->placeholder('Leave empty for all questions')
                                    ->helperText('Number of questions to ask per game. Leave empty to use all available questions.'),

                                TextInput::make('per_question_time')
                                    ->numeric()
                                    ->minValue(5)
                                    ->maxValue(300)
                                    ->placeholder('Leave empty for unlimited time')
                                    ->helperText('Time limit per question in seconds. Leave empty for unlimited time.'),
                            ]),

                        Grid::make(2)
                            ->components([
                                Toggle::make('allow_replay')
                                    ->label('Allow Replay')
                                    ->helperText('Whether users can replay this game')
                                    ->default(true),

                                Toggle::make('show_correct_answers')
                                    ->label('Show Correct Answers')
                                    ->helperText('Whether to show correct answers after quiz completion')
                                    ->default(true),
                            ]),

                        Grid::make(2)
                            ->components([
                                Toggle::make('is_active')
                                    ->label('Active Game')
                                    ->helperText('Whether the game is active and playable')
                                    ->default(true),

                                TextInput::make('max_attempts')
                                    ->numeric()
                                    ->minValue(1)
                                    ->maxValue(50)
                                    ->placeholder('Leave empty for unlimited attempts')
                                    ->helperText('Maximum attempts per user. Leave empty for unlimited attempts.'),
                            ]),
                    ]),

                Section::make('Certificate Template')
                    ->description('Configure the certificate template for this game')
                    ->collapsible()
                    ->collapsed()
                    ->components([
                        KeyValue::make('certificate_template')
                            ->label('Certificate Configuration')
                            ->keyLabel('Field')
                            ->valueLabel('Value')
                            ->default([
                                'title' => 'Certificate of Achievement',
                                'subtitle' => 'Swadeshi Abhiyan',
                                'logo' => 'asset/useswadeshi-remove-bg-logo.png',
                                'signature' => 'Swadeshi Abhiyan Team',
                                'validity' => 'Lifetime',
                                'background_color' => '#f8fafc',
                                'text_color' => '#1e293b',
                                'accent_color' => '#f97316',
                            ])
                            ->helperText('Configure the certificate template. These values will be used when generating certificates for this game.')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
