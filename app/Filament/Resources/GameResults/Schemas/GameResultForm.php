<?php

namespace App\Filament\Resources\GameResults\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class GameResultForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Basic Information')
                    ->description('Basic result information')
                    ->components([
                        Grid::make(2)
                            ->components([
                                Select::make('user_id')
                                    ->relationship('user', 'name')
                                    ->searchable()
                                    ->required()
                                    ->placeholder('Select user'),

                                Select::make('game_id')
                                    ->relationship('game', 'name')
                                    ->searchable()
                                    ->required()
                                    ->placeholder('Select game'),
                            ]),

                        Grid::make(2)
                            ->components([
                                TextInput::make('attempt_number')
                                    ->numeric()
                                    ->minValue(1)
                                    ->default(1)
                                    ->helperText('Attempt number for this user and game'),

                                TextInput::make('certificate_id')
                                    ->placeholder('Auto-generated')
                                    ->helperText('Unique certificate identifier (auto-generated)'),
                            ]),
                    ]),

                Section::make('Performance Metrics')
                    ->description('Quiz performance and scoring details')
                    ->components([
                        Grid::make(3)
                            ->components([
                                TextInput::make('score')
                                    ->required()
                                    ->numeric()
                                    ->minValue(0)
                                    ->helperText('Number of correct answers'),

                                TextInput::make('total_questions')
                                    ->required()
                                    ->numeric()
                                    ->minValue(1)
                                    ->helperText('Total number of questions in the quiz'),

                                TextInput::make('accuracy_percentage')
                                    ->numeric()
                                    ->minValue(0)
                                    ->maxValue(100)
                                    ->step(0.01)
                                    ->suffix('%')
                                    ->helperText('Accuracy percentage'),
                            ]),

                        Grid::make(3)
                            ->components([
                                TextInput::make('correct_answers')
                                    ->numeric()
                                    ->minValue(0)
                                    ->helperText('Number of correct answers'),

                                TextInput::make('incorrect_answers')
                                    ->numeric()
                                    ->minValue(0)
                                    ->helperText('Number of incorrect answers'),

                                TextInput::make('time_taken')
                                    ->numeric()
                                    ->minValue(0)
                                    ->suffix('seconds')
                                    ->helperText('Total time taken in seconds'),
                            ]),

                        Grid::make(2)
                            ->components([
                                TextInput::make('total_points')
                                    ->numeric()
                                    ->minValue(0)
                                    ->helperText('Total points earned'),

                                TextInput::make('max_possible_points')
                                    ->numeric()
                                    ->minValue(0)
                                    ->helperText('Maximum possible points'),
                            ]),
                    ]),

                Section::make('Certificate Information')
                    ->description('Certificate generation details')
                    ->collapsible()
                    ->collapsed()
                    ->components([
                        Grid::make(2)
                            ->components([
                                DateTimePicker::make('certificate_generated_at')
                                    ->label('Certificate Generated At')
                                    ->helperText('When the certificate was generated'),

                                TextInput::make('device_info')
                                    ->label('Device Information')
                                    ->placeholder('Browser/Device info')
                                    ->helperText('Device/browser information'),
                            ]),

                        TextInput::make('ip_address')
                            ->label('IP Address')
                            ->placeholder('User IP address')
                            ->helperText('IP address for analytics'),
                    ]),

                Section::make('Detailed Data')
                    ->description('Detailed question and performance data')
                    ->collapsible()
                    ->collapsed()
                    ->components([
                        KeyValue::make('answers')
                            ->label('User Answers')
                            ->keyLabel('Question')
                            ->valueLabel('Answer')
                            ->helperText('User answers in JSON format')
                            ->columnSpanFull(),

                        KeyValue::make('question_details')
                            ->label('Question Details')
                            ->keyLabel('Field')
                            ->valueLabel('Value')
                            ->helperText('Detailed question-by-question breakdown')
                            ->columnSpanFull(),

                        KeyValue::make('performance_metrics')
                            ->label('Performance Metrics')
                            ->keyLabel('Metric')
                            ->valueLabel('Value')
                            ->helperText('Additional performance metrics')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
