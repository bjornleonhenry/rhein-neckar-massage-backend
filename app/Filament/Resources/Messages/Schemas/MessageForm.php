<?php

namespace App\Filament\Resources\Messages\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class MessageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('E-Mail')
                    ->email()
                    ->maxLength(255),
                TextInput::make('phone')
                    ->label('Telefon')
                    ->required()
                    ->maxLength(255),
                Select::make('service')
                    ->label('Service')
                    ->required()
                    ->options([
                        'Erotik Massage' => 'Erotik Massage',
                        'Tantra Massage' => 'Tantra Massage',
                        'VIP Service' => 'VIP Service',
                        'Paar Erlebnis' => 'Paar Erlebnis',
                        'Body-to-Body' => 'Body-to-Body',
                        'Girlfriend Experience' => 'Girlfriend Experience',
                        'Thai Massage' => 'Thai Massage',
                        'Öl Massage' => 'Öl Massage',
                    ]),
                DatePicker::make('date')
                    ->label('Datum'),
                TimePicker::make('time')
                    ->label('Zeit'),
                Textarea::make('message')
                    ->label('Nachricht')
                    ->columnSpanFull(),
                Toggle::make('is_read')
                    ->label('Gelesen')
                    ->default(false),
            ]);
    }
}
