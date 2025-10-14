<?php

namespace App\Filament\Resources\ProfileOptions\Pages;

use App\Filament\Resources\ProfileOptions\ProfileOptionResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditProfileOption extends EditRecord
{
    protected static string $resource = ProfileOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
