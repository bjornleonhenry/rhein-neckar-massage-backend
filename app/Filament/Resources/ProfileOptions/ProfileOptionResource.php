<?php

namespace App\Filament\Resources\ProfileOptions;

use App\Filament\Resources\ProfileOptions\Pages\CreateProfileOption;
use App\Filament\Resources\ProfileOptions\Pages\EditProfileOption;
use App\Filament\Resources\ProfileOptions\Pages\ListProfileOptions;
use App\Filament\Resources\ProfileOptions\Pages\ViewProfileOption;
use App\Filament\Resources\ProfileOptions\Schemas\ProfileOptionForm;
use App\Filament\Resources\ProfileOptions\Schemas\ProfileOptionInfolist;
use App\Filament\Resources\ProfileOptions\Tables\ProfileOptionsTable;
use App\Models\ProfileOption;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ProfileOptionResource extends Resource
{
    protected static ?string $model = ProfileOption::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-users';

    protected static ?string $recordTitleAttribute = 'option_value';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationLabel = 'Profiles';

    protected static string | \UnitEnum | null $navigationGroup = 'Content';

    public static function form(Schema $schema): Schema
    {
        return ProfileOptionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ProfileOptionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProfileOptionsTable::configure($table);
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
            'index' => ListProfileOptions::route('/'),
            'create' => CreateProfileOption::route('/create'),
            'view' => ViewProfileOption::route('/{record}'),
            'edit' => EditProfileOption::route('/{record}/edit'),
        ];
    }


    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
}
