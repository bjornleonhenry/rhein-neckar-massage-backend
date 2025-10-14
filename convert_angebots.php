<?php
// Script to convert angebots TSV data to PHP array
$data = file_get_contents('angebots_data.txt');
$lines = explode("\n", trim($data));
$headers = str_getcsv(array_shift($lines), "\t");

$angebots = [];
foreach ($lines as $line) {
    if (empty($line)) continue;
    $values = str_getcsv($line, "\t");
    $angebot = [];
    foreach ($headers as $i => $header) {
        $value = $values[$i] ?? null;
        if ($header === 'services' && $value) {
            $value = json_decode($value, true);
        }
        $angebot[$header] = $value;
    }
    $angebots[] = $angebot;
}

file_put_contents('angebots_array.php', "<?php\nreturn " . var_export($angebots, true) . ";\n");