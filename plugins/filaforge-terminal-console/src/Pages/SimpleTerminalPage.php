<?php

namespace Filaforge\TerminalConsole\Pages;

use BackedEnum;
use Filament\Pages\Page;
use UnitEnum;

class SimpleTerminalPage extends Page
{
    protected static BackedEnum | string | null $navigationIcon = 'heroicon-o-command-line';

    protected static ?string $navigationLabel = 'Terminal Console';

    protected static ?string $title = 'Terminal Console';

    protected static UnitEnum | string | null $navigationGroup = 'Settings';

    protected string $view = 'terminal-console::pages.terminal';
}
