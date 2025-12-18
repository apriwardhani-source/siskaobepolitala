<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MahasiswaHasilObeExport implements FromCollection, WithHeadings, WithStyles, WithTitle
{
    public function __construct(private $tahunAngkatan = null, private $kodeProdi = null) {}

    public function collection()
    {
        $q = DB::table('mahasiswas as m')
            ->leftJoin('prodis','m.kode_prodi','=','prodis.kode_prodi')
            ->leftJoin('tahun','m.id_tahun_kurikulum','=','tahun.id_tahun')
            ->select('m.nim','m.nama','prodis.nama_prodi','tahun.tahun');
        if ($this->kodeProdi) $q->where('m.kode_prodi',$this->kodeProdi);
        if ($this->tahunAngkatan) $q->where('tahun.tahun',$this->tahunAngkatan);
        $rows=$q->orderBy('m.nim')->get();
        return $rows->map(fn($r,$i)=>[
            'no'=>$i+1,
            'nim'=>$r->nim,
            'nama'=>$r->nama,
            'prodi'=>$r->nama_prodi,
            'angkatan'=>$r->tahun,
        ]);
    }

    public function headings(): array { return ['No','NIM','Nama','Program Studi','Angkatan']; }
    public function styles(Worksheet $sheet){ return [1=>['font'=>['bold'=>true]]]; }
    public function title(): string { return 'Mahasiswa'; }
}

