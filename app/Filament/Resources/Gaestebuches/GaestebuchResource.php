<?php

namespace App\Filament\Resources\Gaestebuches;

use App\Filament\Resources\Gaestebuches\Pages\CreateGaestebuch;
use App\Filament\Resources\Gaestebuches\Pages\EditGaestebuch;
use App\Filament\Resources\Gaestebuches\Pages\ListGaestebuches;
use App\Filament\Resources\Gaestebuches\Pages\ViewGaestebuch;
use App\Filament\Resources\Gaestebuches\Schemas\GaestebuchForm;
use App\Filament\Resources\Gaestebuches\Schemas\GaestebuchInfolist;
use App\Filament\Resources\Gaestebuches\Tables\GaestebuchesTable;
use App\Models\Gaestebuch;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class GaestebuchResource extends Resource
{
    protected static ?string $model = Gaestebuch::class;

    protected static ?string $recordTitleAttribute = 'Gästebuch';

    protected static ?string $navigationLabel = 'Gästebuch';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;

    protected static ?int $navigationSort = 5;

//    protected static string | \UnitEnum | null $navigationGroup = '';

    public static function form(Schema $schema): Schema
    {
        return GaestebuchForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return GaestebuchInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GaestebuchesTable::configure($table);
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
            'index' => ListGaestebuches::route('/'),
            'create' => CreateGaestebuch::route('/create'),
            'view' => ViewGaestebuch::route('/{record}'),
            'edit' => EditGaestebuch::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
