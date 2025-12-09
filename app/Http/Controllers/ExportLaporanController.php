<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\NilaiMahasiswa;
use App\Models\CapaianProfilLulusan;
use App\Models\CapaianPembelajaranMataKuliah;
use App\Models\SkorCplMahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ExportLaporanController extends Controller
{
    /**
     * Export Daftar Nilai Mahasiswa ke Excel
     */
    public function exportNilai(Request $request)
    {
        $kodeProdi = $request->get('kode_prodi');
        $tahunAjaran = $request->get('tahun_ajaran');
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Header
        $sheet->setCellValue('A1', 'LAPORAN NILAI MAHASISWA');
        $sheet->mergeCells('A1:G1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        // Sub header
        $row = 3;
        $sheet->setCellValue("A{$row}", 'No');
        $sheet->setCellValue("B{$row}", 'NIM');
        $sheet->setCellValue("C{$row}", 'Nama Mahasiswa');
        $sheet->setCellValue("D{$row}", 'Mata Kuliah');
        $sheet->setCellValue("E{$row}", 'Semester');
        $sheet->setCellValue("F{$row}", 'Nilai');
        $sheet->setCellValue("G{$row}", 'Grade');
        
        // Style header
        $sheet->getStyle("A{$row}:G{$row}")->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'CCCCCC']
            ],
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN]
            ]
        ]);
        
        // Data
        $query = NilaiMahasiswa::with(['mahasiswa', 'mataKuliah', 'teknikPenilaian'])
            ->orderBy('nim');
            
        if ($kodeProdi) {
            $query->whereHas('mahasiswa', function($q) use ($kodeProdi) {
                $q->where('kode_prodi', $kodeProdi);
            });
        }
        
        $nilaiData = $query->get();
        $row++;
        $no = 1;
        
        foreach ($nilaiData as $nilai) {
            $sheet->setCellValue("A{$row}", $no++);
            $sheet->setCellValue("B{$row}", $nilai->nim);
            $sheet->setCellValue("C{$row}", $nilai->mahasiswa->nama_mahasiswa ?? '-');
            $sheet->setCellValue("D{$row}", $nilai->mataKuliah->nama_mk ?? '-');
            $sheet->setCellValue("E{$row}", $nilai->mataKuliah->semester ?? '-');
            $sheet->setCellValue("F{$row}", $nilai->nilai_angka);
            $sheet->setCellValue("G{$row}", $this->getGrade($nilai->nilai_angka));
            $row++;
        }
        
        // Auto size columns
        foreach(range('A','G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        // Download
        $filename = 'Laporan_Nilai_' . date('Y-m-d_His') . '.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"{$filename}\"");
        header('Cache-Control: max-age=0');
        
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
    
    /**
     * Export Pencapaian CPL Mahasiswa
     */
    public function exportPencapaianCPL(Request $request)
    {
        $kodeProdi = $request->get('kode_prodi');
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Header
        $sheet->setCellValue('A1', 'LAPORAN PENCAPAIAN CPL MAHASISWA');
        $sheet->mergeCells('A1:F1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        // Get CPL list
        $cplList = CapaianProfilLulusan::where('kode_prodi', $kodeProdi)->get();
        
        // Header columns
        $row = 3;
        $col = 'A';
        $sheet->setCellValue("{$col}{$row}", 'No');
        $col++;
        $sheet->setCellValue("{$col}{$row}", 'NIM');
        $col++;
        $sheet->setCellValue("{$col}{$row}", 'Nama');
        $col++;
        
        foreach ($cplList as $cpl) {
            $sheet->setCellValue("{$col}{$row}", $cpl->kode_cpl);
            $col++;
        }
        $sheet->setCellValue("{$col}{$row}", 'Rata-rata');
        
        // Style header
        $lastCol = $col;
        $sheet->getStyle("A{$row}:{$lastCol}{$row}")->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'CCCCCC']
            ]
        ]);
        
        // Data mahasiswa
        $mahasiswaData = Mahasiswa::where('kode_prodi', $kodeProdi)->get();
        $row++;
        $no = 1;
        
        foreach ($mahasiswaData as $mhs) {
            $col = 'A';
            $sheet->setCellValue("{$col}{$row}", $no++);
            $col++;
            $sheet->setCellValue("{$col}{$row}", $mhs->nim);
            $col++;
            $sheet->setCellValue("{$col}{$row}", $mhs->nama_mahasiswa);
            $col++;
            
            $total = 0;
            $count = 0;
            
            foreach ($cplList as $cpl) {
                $skor = SkorCplMahasiswa::where('nim', $mhs->nim)
                    ->where('id_cpl', $cpl->id_cpl)
                    ->first();
                    
                $nilai = $skor->skor_cpl ?? 0;
                $sheet->setCellValue("{$col}{$row}", number_format($nilai, 2));
                $col++;
                
                $total += $nilai;
                $count++;
            }
            
            $rataRata = $count > 0 ? $total / $count : 0;
            $sheet->setCellValue("{$col}{$row}", number_format($rataRata, 2));
            $row++;
        }
        
        // Auto size
        foreach(range('A', $lastCol) as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
        
        $filename = 'Laporan_Pencapaian_CPL_' . date('Y-m-d_His') . '.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"{$filename}\"");
        header('Cache-Control: max-age=0');
        
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
    
    /**
     * Export Rekap OBE untuk BAN-PT
     */
    public function exportRekapOBE(Request $request)
    {
        $kodeProdi = $request->get('kode_prodi');
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Title
        $sheet->setCellValue('A1', 'REKAP OUTCOME-BASED EDUCATION (OBE)');
        $sheet->mergeCells('A1:E1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        $row = 3;
        
        // Section 1: Statistik CPL
        $sheet->setCellValue("A{$row}", '1. STATISTIK CAPAIAN PEMBELAJARAN LULUSAN (CPL)');
        $sheet->getStyle("A{$row}")->getFont()->setBold(true);
        $row += 2;
        
        $cplStats = SkorCplMahasiswa::select('id_cpl', DB::raw('AVG(skor_cpl) as avg_skor'))
            ->whereHas('cpl', function($q) use ($kodeProdi) {
                $q->where('kode_prodi', $kodeProdi);
            })
            ->groupBy('id_cpl')
            ->with('cpl')
            ->get();
            
        $sheet->setCellValue("A{$row}", 'Kode CPL');
        $sheet->setCellValue("B{$row}", 'Deskripsi');
        $sheet->setCellValue("C{$row}", 'Rata-rata Pencapaian');
        $sheet->setCellValue("D{$row}", 'Status');
        $sheet->getStyle("A{$row}:D{$row}")->getFont()->setBold(true);
        $row++;
        
        foreach ($cplStats as $stat) {
            $avgSkor = $stat->avg_skor ?? 0;
            $status = $avgSkor >= 70 ? 'Tercapai' : 'Perlu Perbaikan';
            
            $sheet->setCellValue("A{$row}", $stat->cpl->kode_cpl ?? '-');
            $sheet->setCellValue("B{$row}", $stat->cpl->deskripsi_cpl ?? '-');
            $sheet->setCellValue("C{$row}", number_format($avgSkor, 2));
            $sheet->setCellValue("D{$row}", $status);
            $row++;
        }
        
        $row += 2;
        
        // Section 2: Pemetaan CPL-MK
        $sheet->setCellValue("A{$row}", '2. PEMETAAN CPL DENGAN MATA KULIAH');
        $sheet->getStyle("A{$row}")->getFont()->setBold(true);
        $row += 2;
        
        $pemetaan = DB::table('cpl_mk')
            ->join('capaian_profil_lulusans', 'cpl_mk.id_cpl', '=', 'capaian_profil_lulusans.id_cpl')
            ->join('mata_kuliahs', 'cpl_mk.kode_mk', '=', 'mata_kuliahs.kode_mk')
            ->where('capaian_profil_lulusans.kode_prodi', $kodeProdi)
            ->select('capaian_profil_lulusans.kode_cpl', 'mata_kuliahs.nama_mk', 'mata_kuliahs.semester')
            ->orderBy('capaian_profil_lulusans.kode_cpl')
            ->get();
            
        $sheet->setCellValue("A{$row}", 'Kode CPL');
        $sheet->setCellValue("B{$row}", 'Mata Kuliah');
        $sheet->setCellValue("C{$row}", 'Semester');
        $sheet->getStyle("A{$row}:C{$row}")->getFont()->setBold(true);
        $row++;
        
        foreach ($pemetaan as $map) {
            $sheet->setCellValue("A{$row}", $map->kode_cpl);
            $sheet->setCellValue("B{$row}", $map->nama_mk);
            $sheet->setCellValue("C{$row}", $map->semester);
            $row++;
        }
        
        // Auto size
        foreach(range('A','E') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        $filename = 'Rekap_OBE_' . date('Y-m-d_His') . '.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"{$filename}\"");
        header('Cache-Control: max-age=0');
        
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
    
    /**
     * Helper: Convert nilai to grade
     */
    private function getGrade($nilai)
    {
        if ($nilai >= 85) return 'A';
        if ($nilai >= 80) return 'A-';
        if ($nilai >= 75) return 'B+';
        if ($nilai >= 70) return 'B';
        if ($nilai >= 65) return 'B-';
        if ($nilai >= 60) return 'C+';
        if ($nilai >= 55) return 'C';
        if ($nilai >= 50) return 'D';
        return 'E';
    }
}
