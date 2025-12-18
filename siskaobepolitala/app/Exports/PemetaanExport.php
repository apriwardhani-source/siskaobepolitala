<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PemetaanExport implements FromCollection, WithHeadings, WithStyles, WithTitle
{
    protected $idTahun;
    protected $kodeProdi;

    public function __construct($idTahun = null, $kodeProdi = null)
    {
        $this->idTahun = $idTahun;
        $this->kodeProdi = $kodeProdi;
    }

    public function collection()
    {
        $query = DB::table('capaian_profil_lulusans as cpl')
            ->join('cpl_cpmk', 'cpl.id_cpl', '=', 'cpl_cpmk.id_cpl')
            ->join('capaian_pembelajaran_mata_kuliahs as cpmk', 'cpl_cpmk.id_cpmk', '=', 'cpmk.id_cpmk')
            ->join('cpmk_mk', 'cpmk.id_cpmk', '=', 'cpmk_mk.id_cpmk')
            ->join('mata_kuliahs as mk', 'cpmk_mk.kode_mk', '=', 'mk.kode_mk')
            ->select(
                'mk.kode_mk',
                'mk.nama_mk',
                'mk.sks_mk',
                'mk.semester_mk',
                'cpmk.kode_cpmk',
                'cpmk.deskripsi_cpmk',
                'cpl.kode_cpl',
                'cpl.deskripsi_cpl'
            );

        if ($this->kodeProdi) {
            $query->where('cpl.kode_prodi', $this->kodeProdi);
        }

        if ($this->idTahun) {
            $query->where('cpl.id_tahun', $this->idTahun);
        }

        $data = $query->orderBy('mk.kode_mk')
            ->orderBy('cpmk.kode_cpmk')
            ->get();

        return $data->map(function ($item, $index) {
            return [
                'no' => $index + 1,
                'kode_mk' => $item->kode_mk,
                'nama_mk' => $item->nama_mk,
                'sks' => $item->sks_mk,
                'semester' => $item->semester_mk,
                'kode_cpmk' => $item->kode_cpmk,
                'deskripsi_cpmk' => $item->deskripsi_cpmk,
                'kode_cpl' => $item->kode_cpl,
                'deskripsi_cpl' => $item->deskripsi_cpl,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Kode MK',
            'Nama Mata Kuliah',
            'SKS',
            'Semester',
            'Kode CPMK',
            'Deskripsi CPMK',
            'Kode CPL',
            'Deskripsi CPL',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }

    public function title(): string
    {
        return 'Pemetaan CPL-CPMK-MK';
    }
}
