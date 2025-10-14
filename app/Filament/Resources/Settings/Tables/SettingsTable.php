<?php

namespace App\Filament\Resources\Settings\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SettingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key')
                    ->label('Setting Key')
                    ->searchable()
                    ->sortable()
                    ->hidden(),
                TextColumn::make('title')
                    ->label('Setting Title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('value')
                    ->label('Value')
                    ->limit(50)
                    ->searchable(),
                TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'string' => 'gray',
                        'boolean' => 'info',
                        'number' => 'success',
                        'text' => 'warning',
                        'json' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->emptyStateHeading('No settings found')
            ->emptyStateDescription('Create your first settings to get started.')
            ->emptyStateIcon('heroicon-o-cog-6-tooth');
    }
}
