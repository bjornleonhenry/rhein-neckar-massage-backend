<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\CalendarWidget;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'Dashboards';

     protected static ?string $navigationLabel = 'Dashboard';

         protected static string | \UnitEnum | null $navigationGroup = '';

    protected static ?int $navigationSort = 0;

    public function getWidgets(): array
    {
        return [
            CalendarWidget::class,
        ];
    }

    public function getColumns(): int | array
    {
        return 12;
    }
}