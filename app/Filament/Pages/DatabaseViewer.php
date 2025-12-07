<?php

namespace App\Filament\Pages;

use Filaforge\DatabaseViewer\Pages\DatabaseViewer as BaseDatabaseViewer;

class DatabaseViewer extends BaseDatabaseViewer
{
    protected static ?string $navigationLabel = 'Database Admin';
    protected static string | \UnitEnum | null $navigationGroup = 'Settings';
     protected static ?int $navigationSort = 0;
}
