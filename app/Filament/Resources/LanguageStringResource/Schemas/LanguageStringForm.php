<?php

namespace App\Filament\Resources\LanguageStringResource\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TagsInput;
use Filament\Schemas\Schema;

class LanguageStringForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('key')
                    ->label('Translation Key')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('e.g., nav.home, button.save')
                    ->helperText('Unique identifier for this translation key')
                    ->unique(ignoreRecord: true)
                    ->disabled(fn ($record) => (bool) $record),

                Select::make('type')
                    ->label('Type')
                    ->options([
                        'text' => 'Text',
                        'button' => 'Button',
                        'title' => 'Title',
                        'nav' => 'Navigation',
                        'footer' => 'Footer',
                        'page' => 'Page',
                        'admin' => 'Admin',
                    ])
                    ->default('text')
                    ->required()
                    ->searchable()
                    ->placeholder('Select type'),
                // Explicit German and English translation fields for simpler editing
                Textarea::make('german_translation')
                    ->label('German')
                    ->rows(3)
                    ->placeholder('Enter German translation')
                    ->helperText('German translation for this key')
                    ->afterStateHydrated(function ($state, $set, $record) {
                        if ($record) {
                            $de = $record->translations()->where('lang', 'de')->first();
                            $set('german_translation', $de?->value);
                        }
                    }),

                Textarea::make('english_translation')
                    ->label('English')
                    ->rows(3)
                    ->placeholder('Enter English translation')
                    ->helperText('English translation for this key')
                    ->afterStateHydrated(function ($state, $set, $record) {
                        if ($record) {
                            $en = $record->translations()->where('lang', 'en')->first();
                            $set('english_translation', $en?->value);
                        }
                    }),

                Textarea::make('default')
                    ->label('Default Value')
                    ->rows(2)
                    ->placeholder('Default text (optional)')
                    ->helperText(''),

                TagsInput::make('tags')
                    ->label('Tags')
                    ->placeholder('Add tags for categorization')
                    ->helperText('Tags to help organize and filter translations'),
            ]);
    }
}
