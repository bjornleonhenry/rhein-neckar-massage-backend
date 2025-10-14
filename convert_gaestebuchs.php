<?php
// Script to convert gaestebuchs TSV data to PHP array
$data = file_get_contents('gaestebuchs_data.txt');
$lines = explode("\n", trim($data));
$headers = str_getcsv(array_shift($lines), "\t");

$gaestebuchs = [];
foreach ($lines as $line) {
    if (empty($line)) continue;
    $values = str_getcsv($line, "\t");
    $gaestebuch = [];
    foreach ($headers as $i => $header) {
        $value = $values[$i] ?? null;
        $gaestebuch[$header] = $value;
    }
    $gaestebuchs[] = $gaestebuch;
}

file_put_contents('gaestebuchs_array.php', "<?php\nreturn " . var_export($gaestebuchs, true) . ";\n");