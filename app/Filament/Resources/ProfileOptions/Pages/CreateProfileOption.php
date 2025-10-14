<?php

namespace App\Filament\Resources\ProfileOptions\Pages;

use App\Filament\Resources\ProfileOptions\ProfileOptionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProfileOption extends CreateRecord
{
    protected static string $resource = ProfileOptionResource::class;
}
