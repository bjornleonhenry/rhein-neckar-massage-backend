<?php

namespace App\Filament\Resources\Ambients;

use App\Filament\Resources\Ambients\Pages\CreateAmbient;
use App\Filament\Resources\Ambients\Pages\EditAmbient;
use App\Filament\Resources\Ambients\Pages\ListAmbients;
use App\Filament\Resources\Ambients\Schemas\AmbientForm;
use App\Filament\Resources\Ambients\Tables\AmbientsTable;
use App\Models\Ambient;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AmbientResource extends Resource
{ 
    protected static ?string $model = Ambient::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHome;

//    protected static string | UnitEnum | null $navigationGroup = 'Content';

    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema
    {
        return AmbientForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AmbientsTable::configure($table);
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
            'index' => ListAmbients::route('/'),
            'create' => CreateAmbient::route('/create'),
            'edit' => EditAmbient::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
