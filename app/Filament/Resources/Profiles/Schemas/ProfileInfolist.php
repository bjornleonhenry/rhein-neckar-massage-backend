<?php

namespace App\Filament\Resources\Profiles\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProfileInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Basic Information')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('name')
                            ->label('Name')
                            ->size('lg')
                            ->weight('bold'),
                        TextEntry::make('age')
                            ->label('Age')
                            ->numeric()
                            ->suffix(' years old')
                            ->size('lg'),
                    ]),

                Section::make('Profile Images')
                    ->schema([
                        TextEntry::make('main_image')
                            ->label('Main Profile Image')
                            ->formatStateUsing(function ($state) {
                                if (!$state) return 'No main image';
                                if (str_contains($state, 'livewire-tmp')) return 'Temporary file';
                                return basename($state);
                            })
                            ->url(fn ($record) => $record->main_image_url)
                            ->openUrlInNewTab()
                            ->copyable()
                            ->copyMessage('Image URL copied!'),
                        TextEntry::make('images')
                            ->label('All Images')
                            ->formatStateUsing(function ($state) {
                                if (!$state || !is_array($state)) return 'No images';
                                $count = count($state);
                                $firstImage = $state[0] ?? '';
                                return "{$count} image(s) - First: " . basename($firstImage);
                            })
                            ->url(fn ($record) => $record->image_urls ? $record->image_urls[0] : null)
                            ->openUrlInNewTab(),
                    ]),

                Section::make('Additional Details')
                    ->columns(1)
                    ->schema([
                        TextEntry::make('description')
                            ->label('Description')
                            ->columnSpanFull()
                            ->markdown()
                            ->visible(fn ($record) => !empty($record->description)),
                        TextEntry::make('languages')
                            ->label('Languages')
                            ->badge()
                            ->separator(',')
                            ->visible(fn ($record) => !empty($record->languages)),
                    ]),

                Section::make('Physical Attributes')
                    ->columns(4)
                    ->schema([
                        TextEntry::make('height')
                            ->label('Height')
                            ->numeric()
                            ->suffix(' cm')
                            ->icon('heroicon-o-arrow-up')
                            ->visible(fn ($record) => !empty($record->height)),
                        TextEntry::make('weight')
                            ->label('Weight')
                            ->numeric()
                            ->suffix(' kg')
                            ->icon('heroicon-o-scale')
                            ->visible(fn ($record) => !empty($record->weight)),
                        TextEntry::make('bust_size')
                            ->label('Bust Size')
                            ->icon('heroicon-o-heart')
                            ->visible(fn ($record) => !empty($record->bust_size)),
                        TextEntry::make('body_type')
                            ->label('Body Type')
                            ->badge()
                            ->color('info')
                            ->visible(fn ($record) => !empty($record->body_type)),
                        TextEntry::make('origin')
                            ->label('Origin')
                            ->icon('heroicon-o-globe-alt')
                            ->visible(fn ($record) => !empty($record->origin)),
                        TextEntry::make('clothing_size')
                            ->label('Clothing Size')
                            ->icon('heroicon-o-shopping-bag')
                            ->visible(fn ($record) => !empty($record->clothing_size)),
                        TextEntry::make('shoe_size')
                            ->label('Shoe Size')
                            ->numeric()
                            ->icon('heroicon-o-shopping-bag')
                            ->visible(fn ($record) => !empty($record->shoe_size)),
                        TextEntry::make('intimate_area')
                            ->label('Intimate Area')
                            ->icon('heroicon-o-user')
                            ->visible(fn ($record) => !empty($record->intimate_area)),
                        TextEntry::make('hair')
                            ->label('Hair')
                            ->icon('heroicon-o-sparkles')
                            ->visible(fn ($record) => !empty($record->hair)),
                        TextEntry::make('eyes')
                            ->label('Eyes')
                            ->icon('heroicon-o-eye')
                            ->visible(fn ($record) => !empty($record->eyes)),
                        TextEntry::make('skin')
                            ->label('Skin')
                            ->icon('heroicon-o-sun')
                            ->visible(fn ($record) => !empty($record->skin)),
                        TextEntry::make('body_jewelry')
                            ->label('Body Jewelry')
                            ->icon('heroicon-o-sparkles')
                            ->visible(fn ($record) => !empty($record->body_jewelry)),
                    ]),

                Section::make('Services & Options')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('intercourse_options')
                            ->label('Intercourse Options')
                            ->badge()
                            ->separator(',')
                            ->color('warning')
                            ->visible(fn ($record) => !empty($record->intercourse_options)),
                        TextEntry::make('services_for')
                            ->label('Services For')
                            ->badge()
                            ->separator(',')
                            ->color('success')
                            ->visible(fn ($record) => !empty($record->services_for)),
                        TextEntry::make('services')
                            ->label('Services')
                            ->badge()
                            ->separator(',')
                            ->color('primary')
                            ->visible(fn ($record) => !empty($record->services)),
                        TextEntry::make('massages')
                            ->label('Massages')
                            ->badge()
                            ->separator(',')
                            ->color('info')
                            ->visible(fn ($record) => !empty($record->massages)),
                        TextEntry::make('meetings')
                            ->label('Meetings')
                            ->badge()
                            ->separator(',')
                            ->color('secondary')
                            ->visible(fn ($record) => !empty($record->meetings)),
                        TextEntry::make('other')
                            ->label('Other Information')
                            ->icon('heroicon-o-information-circle')
                            ->visible(fn ($record) => !empty($record->other)),
                    ]),

                Section::make('Schedule & Additional Info')
                    ->columns(1)
                    ->schema([
                        TextEntry::make('schedule')
                            ->label('Schedule')
                            ->markdown()
                            ->visible(fn ($record) => !empty($record->schedule)),
                        TextEntry::make('additional_info')
                            ->label('Additional Information')
                            ->markdown()
                            ->visible(fn ($record) => !empty($record->additional_info)),
                    ]),

                Section::make('System Information')
                    ->collapsible()
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Created At')
                            ->dateTime('d.m.Y H:i')
                            ->icon('heroicon-o-calendar'),
                        TextEntry::make('updated_at')
                            ->label('Updated At')
                            ->dateTime('d.m.Y H:i')
                            ->icon('heroicon-o-clock'),
                    ]),
            ]);
    }
}
