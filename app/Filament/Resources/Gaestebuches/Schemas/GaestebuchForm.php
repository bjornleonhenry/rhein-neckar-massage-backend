<?php

namespace App\Filament\Resources\Gaestebuches\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class GaestebuchForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                DatePicker::make('date')
                    ->required(),
                TextInput::make('rating')
                    ->required()
                    ->numeric(),
                TextInput::make('service')
                    ->required(),
                Textarea::make('message')
                    ->required()
                    ->columnSpanFull(),
                Toggle::make('verified')
                    ->required(),
            ]);
    }
}
