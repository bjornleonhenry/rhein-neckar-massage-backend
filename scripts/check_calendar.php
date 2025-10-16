<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/../vendor/autoload.php';

echo "After vendor autoload class_exists: ";
var_export(class_exists('App\\Filament\\Widgets\\CalendarWidget'));
echo PHP_EOL;

try {
    require __DIR__ . '/../app/Filament/Widgets/CalendarWidget.php';
    echo "After require file class_exists: ";
    var_export(class_exists('App\\Filament\\Widgets\\CalendarWidget'));
    echo PHP_EOL;
} catch (Throwable $e) {
    echo "Exception while requiring file: " . $e->getMessage() . PHP_EOL;
}

$decl = array_filter(get_declared_classes(), fn($c) => str_contains($c, 'Calendar'));

echo "Declared classes containing 'Calendar':\n";
print_r($decl);
