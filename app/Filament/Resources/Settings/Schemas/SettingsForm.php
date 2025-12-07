<?php

namespace App\Filament\Resources\Settings\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Checkbox;

class SettingsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Setting Details')
                    ->schema([
                        TextInput::make('key')
                            ->label('Setting Key')
                            ->required()
                            ->disabled()
                            ->maxLength(255),
                        TextInput::make('title')
                            ->label('Setting Title')
                            ->required()
                            ->maxLength(255),
                        Select::make('type')
                            ->label('Setting Type')
                            ->options([
                                'string' => 'String',
                                'boolean' => 'Boolean',
                                'number' => 'Number',
                                'text' => 'Text',
                                'json' => 'JSON',
                            ])
                            ->default('string')
                            ->required(),
                        self::getValueField(),
                        Checkbox::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Enable or disable this setting'),
                    ]),
            ]);
    }

    private static function getValueField()
    {
        return TextInput::make('value')
            ->label('Value')
            ->required()
            ->maxLength(1000)
            ->helperText('Enter the value for this setting. For boolean settings, use "true" or "false".');
    }
}
