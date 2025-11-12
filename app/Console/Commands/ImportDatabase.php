<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportDatabase extends Command
{
    protected $signature = 'db:import {--tables=* : Specific tables to import} {--fresh : Clear table before import}';
    protected $description = 'Import database tables from JSON exports';

    public function handle()
    {
        $exportPath = storage_path('app/database-exports');

        if (!file_exists($exportPath)) {
            $this->error('❌ No exports found! Run: php artisan db:export first');
            return 1;
        }

        $files = glob("{$exportPath}/*.json");

        if (empty($files)) {
            $this->error('❌ No JSON files found in exports folder');
            return 1;
        }

        $this->info('🔄 Importing database tables...');
        $this->newLine();

        $fresh = $this->option('fresh');
        $specificTables = $this->option('tables');

        foreach ($files as $file) {
            $tableName = basename($file, '.json');

            // Skip jika user specify table tertentu dan ini bukan salah satunya
            if (!empty($specificTables) && !in_array($tableName, $specificTables)) {
                continue;
            }

            try {
                $json = file_get_contents($file);
                $data = json_decode($json, true);

                if (!is_array($data) || empty($data)) {
                    $this->line("⚠️  {$tableName}: No data to import");
                    continue;
                }

                // Truncate table jika --fresh flag
                if ($fresh) {
                    DB::table($tableName)->truncate();
                }

                // Tentukan primary key untuk setiap tabel
                $primaryKeys = [
                    'mahasiswas' => 'nim',
                    'mata_kuliahs' => 'kode_mk',
                    'prodis' => 'kode_prodi',
                    'tahun' => 'id_tahun',
                    'nilai_mahasiswa' => 'id_nilai',
                    'users' => 'id',
                    'capaian_profil_lulusans' => 'id_cpl',
                    'bahan_kajians' => 'id_bk',
                    'capaian_pembelajaran_mata_kuliahs' => 'id_cpmk',
                ];

                $primaryKey = $primaryKeys[$tableName] ?? 'id';

                // Chunk data untuk performa lebih baik
                $chunks = array_chunk($data, 100);
                $totalInserted = 0;

                foreach ($chunks as $chunk) {
                    // Convert stdClass to array if needed
                    $chunk = array_map(function($item) {
                        return is_object($item) ? (array) $item : $item;
                    }, $chunk);

                    // Insert or update
                    foreach ($chunk as $row) {
                        try {
                            // Get primary key value
                            $keyValue = $row[$primaryKey] ?? null;
                            
                            if ($keyValue === null) {
                                // Skip jika tidak ada primary key
                                continue;
                            }

                            DB::table($tableName)->updateOrInsert(
                                [$primaryKey => $keyValue],
                                $row
                            );
                            $totalInserted++;
                        } catch (\Exception $e) {
                            // Skip row jika error (misal constraint violation)
                            continue;
                        }
                    }
                }

                $this->line("✅ {$tableName}: {$totalInserted} records imported");

            } catch (\Exception $e) {
                $this->error("❌ {$tableName}: {$e->getMessage()}");
            }
        }

        $this->newLine();
        $this->info('✨ Import completed!');
        $this->newLine();
        $this->comment('💡 Database sudah ter-update dengan data dari JSON exports');
    }
}
