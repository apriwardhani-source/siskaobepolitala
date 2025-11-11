<?php

require __DIR__ . '/vendor/autoload.php';

$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
$sheet = $reader->load('Teknik Pengambilan keputusan.xlsx')->getActiveSheet();
$data = $sheet->toArray();

echo "=== STRUKTUR BOBOT ===\n\n";

// Cek baris header untuk bobot
echo "Header Bobot (Row 0, Col 12-18):\n";
for ($col = 12; $col <= 18; $col++) {
    echo "Col $col: " . ($data[0][$col] ?? 'NULL') . "\n";
}

echo "\n=== DATA BOBOT (10 baris pertama) ===\n";
for ($i = 1; $i <= 10; $i++) {
    if (isset($data[$i][12]) && $data[$i][12]) {
        echo "Row $i:\n";
        echo "  Kriteria: " . $data[$i][12] . "\n";
        echo "  Nilai 1: " . ($data[$i][13] ?? 'NULL') . "\n";
        echo "  Nilai 2: " . ($data[$i][14] ?? 'NULL') . "\n";
        echo "  Nilai 3: " . ($data[$i][15] ?? 'NULL') . "\n";
        echo "\n";
    }
}

// Cek semua nilai mahasiswa untuk 1 orang
echo "=== SAMPLE: MAHASISWA PERTAMA ===\n";
echo "NIM: " . $data[1][0] . "\n";
echo "Nama: " . $data[1][1] . "\n";
echo "\nNilai per Mata Kuliah:\n";
$matakuliah = [
    2 => 'Algoritma dan Pemrograman',
    3 => 'Aplikasi Komputer',
    4 => 'Bahasa Inggris',
    5 => 'Desain Grafis',
    6 => 'Interaksi Manusia dan Komputer',
    7 => 'Kalkulus',
    8 => 'Matematika Diskrit',
    9 => 'Pengantar Basis Data',
    10 => 'Sistem Informasi Manajemen'
];

foreach ($matakuliah as $col => $mk) {
    echo "$mk: " . $data[1][$col] . "\n";
}
