<?php

namespace App\Filament\Resources\ProfileOptions\Pages;

use App\Filament\Resources\ProfileOptions\ProfileOptionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListProfileOptions extends ListRecords
{
    protected static string $resource = ProfileOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
