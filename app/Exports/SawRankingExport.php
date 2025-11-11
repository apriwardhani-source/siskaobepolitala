<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SawRankingExport implements FromCollection, WithHeadings, WithStyles, WithTitle
{
    protected $rankings;
    protected $session;

    public function __construct($rankings, $session)
    {
        $this->rankings = $rankings;
        $this->session = $session;
    }

    public function collection()
    {
        return $this->rankings->map(function($rank, $index) {
            return [
                'ranking' => $rank->ranking,
                'nim' => $rank->nim,
                'nama' => $rank->nama_mahasiswa,
                'skor_saw' => round($rank->total_skor, 6)
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Ranking',
            'NIM',
            'Nama Mahasiswa',
            'Skor SAW'
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
        return 'Ranking SAW';
    }
}
