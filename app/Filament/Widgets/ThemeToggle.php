<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Cookie;

class ThemeToggle extends Widget
{
    protected static ?int $sort = -1;

    protected static bool $isLazy = false;

    protected static ?string $pollingInterval = null;

    protected static bool $isPersisted = false;

    protected static string $viewIdentifier = 'theme-toggle';

    protected string $view = 'filament.widgets.theme-toggle';

    protected function getViewData(): array
    {
        return [
            'currentTheme' => $this->getCurrentTheme(),
        ];
    }

    public function getCurrentTheme(): string
    {
        $theme = Cookie::get('theme', 'light');
        return in_array($theme, ['light', 'dark']) ? $theme : 'light';
    }

    public function toggleTheme(): void
    {
        $currentTheme = $this->getCurrentTheme();
        $newTheme = $currentTheme === 'light' ? 'dark' : 'light';

        Cookie::queue('theme', $newTheme, 60 * 24 * 365); // 1 year
    }

    protected function shouldBeRendered(): bool
    {
        return true;
    }

    public static function canView(): bool
    {
        return true;
    }
}
