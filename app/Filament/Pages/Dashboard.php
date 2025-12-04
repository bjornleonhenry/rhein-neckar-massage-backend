<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\CalendarWidget;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'Dashboard';

    protected static ?int $navigationSort = 1;

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