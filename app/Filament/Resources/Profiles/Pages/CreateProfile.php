<?php

namespace App\Filament\Resources\Profiles\Pages;

use App\Filament\Resources\Profiles\ProfileResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProfile extends CreateRecord
{
    protected static string $resource = ProfileResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Auto-set main_image to the first uploaded image if not set
        if (empty($data['main_image']) && !empty($data['images']) && is_array($data['images']) && count($data['images']) > 0) {
            $data['main_image'] = $data['images'][0];
        }
        
        return $data;
    }
}
