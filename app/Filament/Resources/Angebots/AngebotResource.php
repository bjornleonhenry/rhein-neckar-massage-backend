<?php

namespace App\Filament\Resources\Angebots;

use App\Filament\Resources\Angebots\Pages\CreateAngebot;
use App\Filament\Resources\Angebots\Pages\EditAngebot;
use App\Filament\Resources\Angebots\Pages\ListAngebots;
use App\Filament\Resources\Angebots\Pages\ViewAngebot;
use App\Filament\Resources\Angebots\RelationManagers\AngebotOptionsRelationManager;
use App\Filament\Resources\Angebots\Schemas\AngebotForm;
use App\Filament\Resources\Angebots\Schemas\AngebotInfolist;
use App\Filament\Resources\Angebots\Tables\AngebotsTable;
use App\Models\Angebot;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AngebotResource extends Resource
{
    protected static ?string $model = Angebot::class;

    protected static ?string $recordTitleAttribute = 'title';

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-star';

    protected static ?int $navigationSort = 4;

//    protected static string | \UnitEnum | null $navigationGroup = 'Content';

    public static function form(Schema $schema): Schema
    {
        return AngebotForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AngebotInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AngebotsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            AngebotOptionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAngebots::route('/'),
            'create' => CreateAngebot::route('/create'),
            'view' => ViewAngebot::route('/{record}'),
            'edit' => EditAngebot::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
