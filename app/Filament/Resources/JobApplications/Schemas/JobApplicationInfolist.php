<?php

namespace App\Filament\Resources\JobApplications\Schemas;

use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class JobApplicationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Persönliche Daten')
                    ->schema([
                        TextEntry::make('first_name')
                            ->label('Vorname'),
                        TextEntry::make('last_name')
                            ->label('Nachname'),
                        TextEntry::make('age')
                            ->label('Alter'),
                        TextEntry::make('nationality')
                            ->label('Nationalität'),
                        TextEntry::make('languages')
                            ->label('Sprachen'),
                    ])
                    ->columns(3),
                Section::make('Kontaktdaten')
                    ->schema([
                        TextEntry::make('email')
                            ->label('E-Mail'),
                        TextEntry::make('phone')
                            ->label('Telefon'),
                    ])
                    ->columns(2),
                Section::make('Berufliche Informationen')
                    ->schema([
                        TextEntry::make('experience')
                            ->label('Erfahrung')
                            ->formatStateUsing(fn (string $state): string => match($state) {
                                'keine' => 'Keine Erfahrung',
                                'wenig' => 'Wenig Erfahrung (unter 1 Jahr)',
                                'mittel' => 'Mittlere Erfahrung (1-3 Jahre)',
                                'viel' => 'Viel Erfahrung (über 3 Jahre)',
                                default => $state,
                            }),
                        TextEntry::make('availability')
                            ->label('Verfügbarkeit')
                            ->formatStateUsing(fn (string $state): string => match($state) {
                                'vollzeit' => 'Vollzeit',
                                'teilzeit' => 'Teilzeit',
                                'wochenende' => 'Nur Wochenende',
                                'flexibel' => 'Flexibel',
                                default => $state,
                            }),
                        TextEntry::make('specialties')
                            ->label('Spezialitäten')
                            ->listWithLineBreaks()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                Section::make('Bewerbungsdetails')
                    ->schema([
                        TextEntry::make('motivation')
                            ->label('Motivation')
                            ->columnSpanFull()
                            ->prose(),
                        TextEntry::make('references')
                            ->label('Referenzen')
                            ->columnSpanFull()
                            ->prose(),
                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->formatStateUsing(fn (string $state): string => match($state) {
                                'pending' => 'Ausstehend',
                                'reviewing' => 'In Prüfung',
                                'interview' => 'Vorstellungsgespräch',
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
                            }),
                        TextEntry::make('is_read')
                            ->label('Gelesen')
                            ->badge()
                            ->formatStateUsing(fn (string $state): string => $state ? 'Ja' : 'Nein')
                            ->color(fn (string $state): string => $state ? 'success' : 'warning'),
                    ]),
                Section::make('Zeitstempel')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Beworben am')
                            ->dateTime('d.m.Y H:i'),
                        TextEntry::make('updated_at')
                            ->label('Aktualisiert am')
                            ->dateTime('d.m.Y H:i'),
                    ])
                    ->columns(2),
            ]);
    }
}
