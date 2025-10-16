<?php

namespace App\Filament\Resources\LanguageStringResource\Pages;

use App\Filament\Resources\LanguageStringResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLanguageStrings extends ListRecords
{
    protected static string $resource = LanguageStringResource::class;



    protected function getHeaderActions(): array

    {


        return [


            Actions\CreateAction::make()


                ->label('Add Key'),


        ];


        return [];

    }
}
