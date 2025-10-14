<?php
// Script to convert ambients TSV data to PHP array
$data = file_get_contents('ambients_data.txt');
$lines = explode("\n", trim($data));
$headers = str_getcsv(array_shift($lines), "\t");

$ambients = [];
foreach ($lines as $line) {
    if (empty($line)) continue;
    $values = str_getcsv($line, "\t");
    $ambient = [];
    foreach ($headers as $i => $header) {
        $value = $values[$i] ?? null;
        if (in_array($header, ['features', 'amenities']) && $value) {
            $value = json_decode($value, true);
        }
        $ambient[$header] = $value;
    }
    $ambients[] = $ambient;
}

file_put_contents('ambients_array.php', "<?php\nreturn " . var_export($ambients, true) . ";\n");