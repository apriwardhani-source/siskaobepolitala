<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;

class CplExport implements FromCollection, WithHeadings, WithTitle, WithStyles
{
    public function __construct(private $idTahun = null, private $kodeProdi = null) {}

    public function collection()
    {
        $q = DB::table('capaian_profil_lulusans as cpl')
            ->leftJoin('prodis','cpl.kode_prodi','=','prodis.kode_prodi')
            ->leftJoin('tahun','cpl.id_tahun','=','tahun.id_tahun')
            ->select('cpl.kode_cpl','cpl.deskripsi_cpl','prodis.nama_prodi','tahun.tahun');
        if ($this->kodeProdi) $q->where('cpl.kode_prodi',$this->kodeProdi);
        if ($this->idTahun) $q->where('cpl.id_tahun',$this->idTahun);
        $rows = $q->orderBy('cpl.kode_cpl')->get();
        return $rows->map(fn($r,$i)=>[
            'no'=>$i+1,
            'kode_cpl'=>$r->kode_cpl,
            'deskripsi_cpl'=>$r->deskripsi_cpl,
            'prodi'=>$r->nama_prodi,
            'tahun'=>$r->tahun,
        ]);
    }

    public function headings(): array
    { return ['No','Kode CPL','Deskripsi CPL','Program Studi','Tahun']; }

    public function title(): string { return 'CPL'; }

    public function styles(Worksheet $sheet)
    { return [1=>['font'=>['bold'=>true]]]; }
}

