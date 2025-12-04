<?php

namespace Filaforge\Wirechat\Pages;

use BackedEnum;
use Filament\Pages\Page;
use Filament\Panel;
use UnitEnum;

class WirechatPage extends Page
{
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static string | UnitEnum | null $navigationGroup = 'Tools';

    protected static ?string $navigationLabel = 'Wirechat';

    protected string $view = 'filaforge-wirechat::pages.wirechat';

    public static function getSlug(?Panel $panel = null): string
    {
        return 'wirechat';
    }
}
