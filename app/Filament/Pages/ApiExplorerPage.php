<?php

namespace App\Filament\Pages;

use Filaforge\ApiExplorer\Pages\ApiExplorerPage as BaseApiExplorerPage;

class ApiExplorerPage extends BaseApiExplorerPage
{
    protected static ?string $navigationLabel = 'API Query';
    protected static string | \UnitEnum | null $navigationGroup = 'Developer';
     protected static ?int $navigationSort = 10;
}
