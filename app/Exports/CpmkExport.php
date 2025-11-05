<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CpmkExport implements FromCollection, WithHeadings, WithTitle, WithStyles
{
    public function __construct(private $idTahun = null, private $kodeProdi = null) {}

    public function collection()
    {
        $q = DB::table('capaian_pembelajaran_mata_kuliahs as cpmk')
            ->leftJoin('cpl_cpmk','cpmk.id_cpmk','=','cpl_cpmk.id_cpmk')
            ->leftJoin('capaian_profil_lulusans as cpl','cpl_cpmk.id_cpl','=','cpl.id_cpl')
            ->leftJoin('prodis','cpl.kode_prodi','=','prodis.kode_prodi')
            ->leftJoin('tahun','cpl.id_tahun','=','tahun.id_tahun')
            ->select('cpmk.kode_cpmk','cpmk.deskripsi_cpmk','prodis.nama_prodi','tahun.tahun')
            ->groupBy('cpmk.kode_cpmk','cpmk.deskripsi_cpmk','prodis.nama_prodi','tahun.tahun');
        if ($this->kodeProdi) $q->where('cpl.kode_prodi',$this->kodeProdi);
        if ($this->idTahun) $q->where('cpl.id_tahun',$this->idTahun);
        $rows=$q->orderBy('cpmk.kode_cpmk')->get();
        return $rows->map(fn($r,$i)=>[
            'no'=>$i+1,
            'kode_cpmk'=>$r->kode_cpmk,
            'deskripsi_cpmk'=>$r->deskripsi_cpmk,
            'prodi'=>$r->nama_prodi,
            'tahun'=>$r->tahun,
        ]);
    }

    public function headings(): array { return ['No','Kode CPMK','Deskripsi CPMK','Program Studi','Tahun']; }
    public function title(): string { return 'CPMK'; }
    public function styles(Worksheet $sheet){ return [1=>['font'=>['bold'=>true]]]; }
}

