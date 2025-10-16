<?php

namespace App\Filament\Resources\LanguageStringResource\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Models\LanguageKey;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class LanguageStringsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->query(fn (Builder $query) => LanguageKey::query())
            ->columns([
                TextColumn::make('key')
                    ->label('Translation Key')
                    ->searchable()
                    ->sortable()
                    ->limit(30)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 30) {
                            return null;
                        }
                        return $state;
                    }),

                TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'button' => 'danger',
                        'text' => 'secondary',
                        'title' => 'warning',
                        'nav' => 'info',
                        'footer' => 'gray',
                        'page' => 'success',
                        'admin' => 'danger',
            'alert' => 'warning',
            'contact' => 'primary',
            'testimonials' => 'white',
            'label' => 'danger',
            'custom' => 'success',
            'other' => 'black',
                        default => 'secondary',
                    })
                    ->searchable()
                    ->sortable(),

                TextColumn::make('translations_count')
                    ->label('Translations')
                    ->getStateUsing(fn ($record) => $record->translations()->count())
                    ->badge()
                    ->color('success'),

                TextColumn::make('english_translation')
                    ->label('English')
                    ->getStateUsing(fn ($record) => $record->getTranslation('en') ?? '-')
                    ->searchable(query: function ($query, $search) {
                        return $query->whereHas('translations', function ($translationQuery) use ($search) {
                            $translationQuery->where('value', 'like', "%{$search}%")
                                           ->where('lang', 'en')
                                           ->where('is_active', true);
                        });
                    })
                    ->limit(30)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if ($state === '-' || strlen($state) <= 30) {
                            return null;
                        }
                        return $state;
                    }),

                TextColumn::make('german_translation')
                    ->label('German')
                    ->getStateUsing(fn ($record) => $record->getTranslation('de') ?? '-')
                    ->searchable(query: function ($query, $search) {
                        return $query->whereHas('translations', function ($translationQuery) use ($search) {
                            $translationQuery->where('value', 'like', "%{$search}%")
                                           ->where('lang', 'de')
                                           ->where('is_active', true);
                        });
                    })
                    ->limit(30)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if ($state === '-' || strlen($state) <= 30) {
                            return null;
                        }
                        return $state;
                    }),

                ToggleColumn::make('is_active')
                    ->label('Active')
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime('M j, Y g:i A')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Type')
                    ->options([
            'text' => 'Text',
            'button' => 'Button',
            'title' => 'Title',
            'nav' => 'Navigation',
            'footer' => 'Footer',
            'header' => 'Header',
            'page' => 'Page',
            'admin' => 'Admin',
            'component' => 'Component',
            'alert' => 'Alert',
            'contact' => 'Contact',
            'testimonials' => 'Testimonials',
            'label' => 'Label',
            'custom' => 'Custom',
            'other' => 'Other',
                    ])
                    ->multiple()
                    ->searchable(),

                TernaryFilter::make('is_active')
                    ->label('Active Status')
                    ->placeholder('All')
                    ->trueLabel('Active only')
                    ->falseLabel('Inactive only'),
            ])
            ->searchable()
            ->recordActions([
                EditAction::make(),
 //              DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPaginationPageOptions(): array
    {
        return [10, 25, 50, 100];
    }
}
