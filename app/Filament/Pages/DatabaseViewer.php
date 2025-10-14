<?php

namespace App\Filament\Pages;

use Filaforge\DatabaseViewer\Pages\DatabaseViewer as BaseDatabaseViewer;

class DatabaseViewer extends BaseDatabaseViewer
{
    protected static ?string $navigationLabel = 'Database';
    protected static string | \UnitEnum | null $navigationGroup = 'System';
     protected static ?int $navigationSort = 8;
}
