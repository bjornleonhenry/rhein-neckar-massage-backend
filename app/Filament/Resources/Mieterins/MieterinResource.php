<?php

namespace App\Filament\Resources\Mieterins;

use App\Filament\Resources\Mieterins\Pages\CreateMieterin;
use App\Filament\Resources\Mieterins\Pages\EditMieterin;
use App\Filament\Resources\Mieterins\Pages\ListMieterins;
use App\Filament\Resources\Mieterins\Pages\ViewMieterin;
use App\Filament\Resources\Mieterins\Schemas\MieterinForm;
use App\Filament\Resources\Mieterins\Schemas\MieterinInfolist;
use App\Filament\Resources\Mieterins\Tables\MieterinsTable;
use App\Models\Mieterin;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MieterinResource extends Resource
{
    protected static ?string $model = Mieterin::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUser;

    protected static ?int $navigationSort = 2;

    protected static string | \UnitEnum | null $navigationGroup = 'Content';

    public static function form(Schema $schema): Schema
    {
        return MieterinForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MieterinInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MieterinsTable::configure($table);
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
            'index' => ListMieterins::route('/'),
            'create' => CreateMieterin::route('/create'),
            'view' => ViewMieterin::route('/{record}'),
            'edit' => EditMieterin::route('/{record}/edit'),
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
