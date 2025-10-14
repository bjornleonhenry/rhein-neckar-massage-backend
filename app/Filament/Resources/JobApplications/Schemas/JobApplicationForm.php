<?php

namespace App\Filament\Resources\JobApplications\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class JobApplicationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('first_name')
                    ->label('Vorname')
                    ->required()
                    ->maxLength(255),
                TextInput::make('last_name')
                    ->label('Nachname')
                    ->required()
                    ->maxLength(255),
                TextInput::make('age')
                    ->label('Alter')
                    ->required()
                    ->numeric()
                    ->minValue(21)
                    ->maxValue(100),
                TextInput::make('nationality')
                    ->label('Nationalität')
                    ->required()
                    ->maxLength(255),
                TextInput::make('languages')
                    ->label('Sprachen')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('E-Mail')
                    ->email()
                    ->required()
                    ->maxLength(255),
                TextInput::make('phone')
                    ->label('Telefon')
                    ->required()
                    ->maxLength(255),
                Select::make('experience')
                    ->label('Erfahrung')
                    ->options([
                        'keine' => 'Keine Erfahrung',
                        'wenig' => 'Wenig Erfahrung (unter 1 Jahr)',
                        'mittel' => 'Mittlere Erfahrung (1-3 Jahre)',
                        'viel' => 'Viel Erfahrung (über 3 Jahre)',
                    ])
                    ->placeholder('Bitte wählen'),
                Select::make('availability')
                    ->label('Verfügbarkeit')
                    ->options([
                        'vollzeit' => 'Vollzeit',
                        'teilzeit' => 'Teilzeit',
                        'wochenende' => 'Nur Wochenende',
                        'flexibel' => 'Flexibel',
                    ])
                    ->placeholder('Bitte wählen'),
                CheckboxList::make('specialties')
                    ->label('Spezialitäten')
                    ->options([
                        'Thai Massage' => 'Thai Massage',
                        'Erotik Massage' => 'Erotik Massage',
                        'Tantra Massage' => 'Tantra Massage',
                        'Öl Massage' => 'Öl Massage',
                        'Body-to-Body' => 'Body-to-Body',
                        'Paar Behandlungen' => 'Paar Behandlungen',
                        'VIP Service' => 'VIP Service',
                        'Girlfriend Experience' => 'Girlfriend Experience',
                    ])
                    ->columns(2),
                Textarea::make('motivation')
                    ->label('Motivation')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('references')
                    ->label('Referenzen')
                    ->columnSpanFull(),
                Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Ausstehend',
                        'reviewing' => 'In Prüfung',
                        'interview' => 'Vorstellungsgespräch',
                        'accepted' => 'Angenommen',
                        'rejected' => 'Abgelehnt',
                    ])
                    ->default('pending')
                    ->required(),
                Toggle::make('is_read')
                    ->label('Gelesen')
                    ->default(false),
            ]);
    }
}
