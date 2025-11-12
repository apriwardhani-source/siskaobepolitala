<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ExportDatabase extends Command
{
    protected $signature = 'db:export {--tables=* : Specific tables to export}';
    protected $description = 'Export database tables to JSON for team sharing';

    public function handle()
    {
        $tables = $this->option('tables') ?: [
            'mahasiswas',
            'nilai_mahasiswa',
            'mata_kuliahs',
            'tahun',
            'prodis',
        ];

        $exportPath = storage_path('app/database-exports');
        
        if (!file_exists($exportPath)) {
            mkdir($exportPath, 0755, true);
        }

        $this->info('🔄 Exporting database tables...');
        $this->newLine();

        foreach ($tables as $table) {
            try {
                $data = DB::table($table)->get()->toArray();
                $count = count($data);
                
                if ($count > 0) {
                    $filename = "{$exportPath}/{$table}.json";
                    file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT));
                    $this->line("✅ {$table}: {$count} records exported");
                } else {
                    $this->line("⚠️  {$table}: No data to export");
                }
            } catch (\Exception $e) {
                $this->error("❌ {$table}: {$e->getMessage()}");
            }
        }

        $this->newLine();
        $this->info('✨ Export completed!');
        $this->info("📁 Location: {$exportPath}");
        $this->newLine();
        $this->comment('💡 Tip: Commit file JSON ke Git agar tim bisa sync data');
        $this->comment("   git add storage/app/database-exports/*.json");
        $this->comment("   git commit -m \"Update database exports\"");
    }
}
