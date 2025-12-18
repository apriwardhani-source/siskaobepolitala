<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MataKuliahExport implements FromCollection, WithHeadings, WithTitle, WithStyles
{
    public function __construct(private $idTahun = null, private $kodeProdi = null) {}

    public function collection()
    {
        $q = DB::table('mata_kuliahs as mk')
            ->leftJoin('cpl_mk','mk.kode_mk','=','cpl_mk.kode_mk')
            ->leftJoin('capaian_profil_lulusans as cpl','cpl_mk.id_cpl','=','cpl.id_cpl')
            ->leftJoin('prodis','cpl.kode_prodi','=','prodis.kode_prodi')
            ->leftJoin('tahun','cpl.id_tahun','=','tahun.id_tahun')
            ->select('mk.kode_mk','mk.nama_mk','mk.sks_mk','mk.semester_mk','prodis.nama_prodi','tahun.tahun')
            ->groupBy('mk.kode_mk','mk.nama_mk','mk.sks_mk','mk.semester_mk','prodis.nama_prodi','tahun.tahun');
        if ($this->kodeProdi) $q->where('cpl.kode_prodi',$this->kodeProdi);
        if ($this->idTahun) $q->where('cpl.id_tahun',$this->idTahun);
        $rows = $q->orderBy('mk.kode_mk')->get();
        return $rows->map(fn($r,$i)=>[
            'no'=>$i+1,
            'kode_mk'=>$r->kode_mk,
            'nama_mk'=>$r->nama_mk,
            'sks'=>$r->sks_mk,
            'semester'=>$r->semester_mk,
            'prodi'=>$r->nama_prodi,
            'tahun'=>$r->tahun,
        ]);
    }

    public function headings(): array
    { return ['No','Kode MK','Nama MK','SKS','Semester','Program Studi','Tahun']; }
    public function title(): string { return 'Mata Kuliah'; }
    public function styles(Worksheet $sheet){ return [1=>['font'=>['bold'=>true]]]; }
}

