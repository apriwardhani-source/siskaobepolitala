<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BobotExport implements FromCollection, WithHeadings, WithTitle, WithStyles
{
    public function __construct(private $idTahun = null, private $kodeProdi = null) {}

    public function collection()
    {
        $q = DB::table('bobots as b')
            ->leftJoin('capaian_profil_lulusans as cpl','b.id_cpl','=','cpl.id_cpl')
            ->leftJoin('mata_kuliahs as mk','b.kode_mk','=','mk.kode_mk')
            ->leftJoin('prodis','cpl.kode_prodi','=','prodis.kode_prodi')
            ->leftJoin('tahun','cpl.id_tahun','=','tahun.id_tahun')
            ->select('mk.kode_mk','mk.nama_mk','cpl.kode_cpl','b.bobot','prodis.nama_prodi','tahun.tahun');
        if ($this->kodeProdi) $q->where('cpl.kode_prodi',$this->kodeProdi);
        if ($this->idTahun) $q->where('cpl.id_tahun',$this->idTahun);
        $rows=$q->orderBy('mk.kode_mk')->get();
        return $rows->map(fn($r,$i)=>[
            'no'=>$i+1,
            'kode_mk'=>$r->kode_mk,
            'nama_mk'=>$r->nama_mk,
            'kode_cpl'=>$r->kode_cpl,
            'bobot'=>$r->bobot,
            'prodi'=>$r->nama_prodi,
            'tahun'=>$r->tahun,
        ]);
    }

    public function headings(): array { return ['No','Kode MK','Nama MK','Kode CPL','Bobot','Program Studi','Tahun']; }
    public function title(): string { return 'Bobot CPL-MK'; }
    public function styles(Worksheet $sheet){ return [1=>['font'=>['bold'=>true]]]; }
}

