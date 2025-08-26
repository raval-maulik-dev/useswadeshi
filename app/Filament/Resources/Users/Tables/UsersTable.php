<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable()
                    ->sortable()
                    ->copyable(),

                TextColumn::make('phone')
                    ->searchable()
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('city')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('state')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('country')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                BadgeColumn::make('role')
                    ->colors([
                        'primary' => 'user',
                        'success' => 'vendor',
                        'danger' => 'admin',
                    ])
                    ->sortable(),

                IconColumn::make('email_verified_at')
                    ->label('Email Verified')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('gameResults_count')
                    ->label('Quiz Attempts')
                    ->counts('gameResults')
                    ->badge()
                    ->color('info')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Joined')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->options([
                        'user' => 'User',
                        'vendor' => 'Vendor',
                        'admin' => 'Admin',
                    ]),

                Filter::make('verified')
                    ->query(fn ($query) => $query->whereNotNull('email_verified_at'))
                    ->label('Email Verified'),

                Filter::make('unverified')
                    ->query(fn ($query) => $query->whereNull('email_verified_at'))
                    ->label('Email Not Verified'),

                Filter::make('has_phone')
                    ->query(fn ($query) => $query->whereNotNull('phone'))
                    ->label('Has Phone Number'),

                Filter::make('has_location')
                    ->query(fn ($query) => $query->whereNotNull('city')->orWhereNotNull('state')->orWhereNotNull('country'))
                    ->label('Has Location Info'),

                Filter::make('active_users')
                    ->query(fn ($query) => $query->has('gameResults'))
                    ->label('Active Users (Has Quiz Attempts)'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
