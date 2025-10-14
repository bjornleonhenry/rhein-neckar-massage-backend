<?php

namespace App\Filament\Resources\JobApplications\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class JobApplicationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('first_name')
                    ->label('Vorname')
                    ->searchable(),
                TextColumn::make('last_name')
                    ->label('Nachname')
                    ->searchable(),
                TextColumn::make('age')
                    ->label('Alter')
                    ->sortable(),
                TextColumn::make('email')
                    ->label('E-Mail')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('phone')
                    ->label('Telefon')
                    ->searchable(),
                TextColumn::make('nationality')
                    ->label('Nationalität')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('experience')
                    ->label('Erfahrung')
                    ->formatStateUsing(fn (string $state): string => match($state) {
                        'keine' => 'Keine',
                        'wenig' => 'Wenig',
                        'mittel' => 'Mittel',
                        'viel' => 'Viel',
                        default => $state,
                    })
                    ->sortable(),
                TextColumn::make('availability')
                    ->label('Verfügbarkeit')
                    ->formatStateUsing(fn (string $state): string => match($state) {
                        'vollzeit' => 'Vollzeit',
                        'teilzeit' => 'Teilzeit',
                        'wochenende' => 'Wochenende',
                        'flexibel' => 'Flexibel',
                        default => $state,
                    })
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match($state) {
                        'pending' => 'Ausstehend',
                        'reviewing' => 'In Prüfung',
                        'interview' => 'Interview',
                        'accepted' => 'Angenommen',
                        'rejected' => 'Abgelehnt',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match($state) {
                        'pending' => 'warning',
                        'reviewing' => 'info',
                        'interview' => 'primary',
                        'accepted' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                IconColumn::make('is_read')
                    ->label('Gelesen')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Beworben am')
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
