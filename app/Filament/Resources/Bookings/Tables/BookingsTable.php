<?php

namespace App\Filament\Resources\Bookings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BookingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('girl')
                    ->label('Masseurin')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('service')
                    ->label('Service')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Kunde')
                    ->searchable(),
                TextColumn::make('phone')
                    ->label('Telefon')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('email')
                    ->label('E-Mail')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('date')
                    ->label('Datum')
                    ->date('d.m.Y')
                    ->sortable(),
                TextColumn::make('time')
                    ->label('Uhrzeit')
                    ->time('H:i')
                    ->sortable(),
                TextColumn::make('price')
                    ->label('Preis')
                    ->money('EUR')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match($state) {
                        'pending' => 'Ausstehend',
                        'confirmed' => 'Bestätigt',
                        'cancelled' => 'Storniert',
                        'completed' => 'Abgeschlossen',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match($state) {
                        'pending' => 'warning',
                        'confirmed' => 'success',
                        'cancelled' => 'danger',
                        'completed' => 'info',
                        default => 'gray',
                    })
                    ->sortable(),
                IconColumn::make('is_read')
                    ->label('Gelesen')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Erstellt am')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
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
