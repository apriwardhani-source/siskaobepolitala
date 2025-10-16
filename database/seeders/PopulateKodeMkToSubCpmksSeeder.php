<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PopulateKodeMkToSubCpmksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update sub_cpmks table to populate kode_mk based on the cpmk_mk relationship
        $subCpmks = DB::table('sub_cpmks as sub')
            ->leftJoin('cpmk_mk', 'sub.id_cpmk', '=', 'cpmk_mk.id_cpmk')
            ->select('sub.id_sub_cpmk', 'cpmk_mk.kode_mk')
            ->get();

        foreach ($subCpmks as $subCpmk) {
            if ($subCpmk->kode_mk) {
                DB::table('sub_cpmks')
                    ->where('id_sub_cpmk', $subCpmk->id_sub_cpmk)
                    ->update(['kode_mk' => $subCpmk->kode_mk]);
            }
        }
    }
}
