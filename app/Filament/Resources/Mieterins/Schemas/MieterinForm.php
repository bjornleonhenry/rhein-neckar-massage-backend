<?php

namespace App\Filament\Resources\Mieterins\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class MieterinForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('age')
                    ->required()
                    ->numeric(),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                FileUpload::make('image')
                    ->image()
                    ->directory('mieterinnen')
                    ->visibility('public'),
                Textarea::make('specialties')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('languages')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('working_hours')
                    ->required(),
                TextInput::make('rating')
                    ->required()
                    ->numeric(),
            ]);
    }
}
