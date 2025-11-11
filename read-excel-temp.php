<?php

require __DIR__ . '/vendor/autoload.php';

use Maatwebsite\Excel\Facades\Excel;

$file = 'Teknik Pengambilan keputusan.xlsx';

// Read Excel using PhpSpreadsheet directly
$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
$spreadsheet = $reader->load($file);
$worksheet = $spreadsheet->getActiveSheet();

// Get data as array
$data = $worksheet->toArray();

// Print header
echo "=== HEADER (Row 1) ===\n";
print_r($data[0]);

echo "\n=== SAMPLE DATA (5 rows) ===\n";
for ($i = 0; $i < min(6, count($data)); $i++) {
    echo "Row $i: ";
    print_r($data[$i]);
}

echo "\n=== INFO ===\n";
echo "Total Rows: " . count($data) . "\n";
echo "Total Columns: " . (count($data[0] ?? [])) . "\n";

// Print structure
echo "\n=== COLUMN STRUCTURE ===\n";
if (isset($data[0])) {
    foreach ($data[0] as $idx => $colName) {
        echo "Column $idx: $colName\n";
    }
}
