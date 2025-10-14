<?php

namespace App\Filament\Resources\LanguageStringResource\Pages;

use App\Filament\Resources\LanguageStringResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateLanguageString extends CreateRecord
{
    protected static string $resource = LanguageStringResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterCreate(): void
    {
        /** @var Model $record */
        $record = $this->record;

        $data = $this->form->getState();

        if (array_key_exists('english_translation', $data)) {
            $en = $record->translations()->firstOrNew(['lang' => 'en']);
            $en->value = $data['english_translation'];
            $en->is_active = true;
            $record->translations()->save($en);
        }

        if (array_key_exists('german_translation', $data)) {
            $de = $record->translations()->firstOrNew(['lang' => 'de']);
            $de->value = $data['german_translation'];
            $de->is_active = true;
            $record->translations()->save($de);
        }
    }
}
