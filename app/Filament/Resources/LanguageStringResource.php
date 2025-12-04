<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LanguageStringResource\Pages;
use App\Filament\Resources\LanguageStringResource\Schemas\LanguageStringForm;
use App\Filament\Resources\LanguageStringResource\Tables\LanguageStringsTable;
use App\Models\LanguageKey;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class LanguageStringResource extends Resource
{
    protected static ?string $model = LanguageKey::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-language';

//    protected static string | \UnitEnum | null $navigationGroup = 'Settings';

    protected static ?string $navigationLabel = 'Languages';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return LanguageStringForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LanguageStringsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLanguageStrings::route('/'),
            'create' => Pages\CreateLanguageString::route('/create'),
            'edit' => Pages\EditLanguageString::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        // Force Filament to query LanguageKey model for listing and record actions
        return static::getModel()::query();
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $german = $data['german_translation'] ?? null;
        $english = $data['english_translation'] ?? null;
        unset($data['german_translation'], $data['english_translation']);
        $this->german = $german;
        $this->english = $english;
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $german = $data['german_translation'] ?? null;
        $english = $data['english_translation'] ?? null;
        unset($data['german_translation'], $data['english_translation']);
        $this->german = $german;
        $this->english = $english;
        return $data;
    }

    protected function afterCreate(): void
    {
        $this->saveTranslations();
    }

    protected function afterSave(): void
    {
        $this->saveTranslations();
    }

    private function saveTranslations(): void
    {
        $record = $this->record;
        if ($this->german !== null) {
            $record->translations()->updateOrCreate(
                ['lang' => 'de'],
                ['value' => $this->german, 'is_active' => true]
            );
        }
        if ($this->english !== null) {
            $record->translations()->updateOrCreate(
                ['lang' => 'en'],
                ['value' => $this->english, 'is_active' => true]
            );
        }
    }
}
