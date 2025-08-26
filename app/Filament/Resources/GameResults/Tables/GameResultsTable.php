<?php

namespace App\Filament\Resources\GameResults\Tables;

use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class GameResultsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('game.name')
                    ->label('Game')
                    ->searchable()
                    ->sortable()
                    ->color('primary'),

                TextColumn::make('score')
                    ->label('Score')
                    ->formatStateUsing(fn ($state, $record) => "{$state}/{$record->total_questions}")
                    ->badge()
                    ->color('info')
                    ->sortable(),

                TextColumn::make('accuracy_percentage')
                    ->label('Accuracy')
                    ->formatStateUsing(fn ($state) => $state ? number_format($state, 1).'%' : 'N/A')
                    ->badge()
                    ->color(fn ($state) => $state >= 80 ? 'success' :
                        ($state >= 60 ? 'warning' : 'danger')
                    )
                    ->sortable(),

                TextColumn::make('total_points')
                    ->label('Points')
                    ->formatStateUsing(fn ($state) => $state ?: '0')
                    ->badge()
                    ->color('success')
                    ->sortable(),

                TextColumn::make('time_taken')
                    ->label('Time')
                    ->formatStateUsing(function ($state) {
                        if (! $state) {
                            return 'N/A';
                        }
                        $minutes = floor($state / 60);
                        $seconds = $state % 60;

                        return $minutes > 0 ? "{$minutes}m {$seconds}s" : "{$seconds}s";
                    })
                    ->badge()
                    ->color('secondary')
                    ->sortable(),

                TextColumn::make('attempt_number')
                    ->label('Attempt')
                    ->badge()
                    ->color('warning')
                    ->sortable(),

                TextColumn::make('certificate_id')
                    ->label('Certificate')
                    ->formatStateUsing(fn ($state) => $state ? 'Generated' : 'Not Generated')
                    ->badge()
                    ->color(fn ($state) => $state ? 'success' : 'gray'),

                TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('M d, Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([
                SelectFilter::make('game_id')
                    ->label('Game')
                    ->relationship('game', 'name')
                    ->searchable(),

                SelectFilter::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name')
                    ->searchable(),

                Filter::make('high_performers')
                    ->label('High Performers (80%+)')
                    ->query(fn ($query) => $query->where('accuracy_percentage', '>=', 80)),

                Filter::make('certificate_generated')
                    ->label('Certificate Generated')
                    ->query(fn ($query) => $query->whereNotNull('certificate_id')),

                Filter::make('recent_results')
                    ->label('Recent Results (Last 7 days)')
                    ->query(fn ($query) => $query->where('created_at', '>=', now()->subDays(7))),
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
