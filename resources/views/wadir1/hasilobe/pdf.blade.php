<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil OBE - {{ $mahasiswa->nim }}</title>
    <style>
        body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; font-size: 12px; color: #111827; }
        .header { margin-bottom: 12px; }
        .title { font-size: 18px; font-weight: bold; margin: 0 0 4px 0; }
        .meta { font-size: 12px; color: #374151; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; border: 1px solid #e5e7eb; }
        th { background: #f3f4f6; text-align: left; font-weight: 600; }
        .badge { display: inline-block; padding: 2px 6px; border-radius: 6px; font-size: 11px; }
        .badge-gray { background: #f3f4f6; color: #6b7280; }
        .badge-amber { background: #fef3c7; color: #92400e; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .mt-2 { margin-top: 8px; }
        .mt-4 { margin-top: 16px; }
        .small { font-size: 11px; color: #6b7280; }
    </style>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
</head>
<body>
    <div class="header">
        <div class="title">Hasil OBE Mahasiswa</div>
        <div class="meta">
            Nama: <strong>{{ $mahasiswa->nama_mahasiswa }}</strong><br/>
            NIM: <strong>{{ $mahasiswa->nim }}</strong><br/>
            Prodi: <strong>{{ $mahasiswa->prodi->nama_prodi ?? '-' }}</strong>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 55px;">Semester</th>
                <th style="width: 90px;">Kode MK</th>
                <th>Nama MK</th>
                <th style="width: 40px;">SKS</th>
                <th style="width: 90px;">CPL</th>
                <th style="width: 90px;">CPMK</th>
                <th style="width: 70px;" class="text-center">Skor Maks</th>
                <th style="width: 90px;" class="text-center">Nilai</th>
            </tr>
        </thead>
        <tbody>
            @foreach($grouped_data as $mk)
                @php $rowspan = max(1, $mk['details']->count()); @endphp
                <tr>
                    <td class="text-center" rowspan="{{ $rowspan }}">{{ $mk['semester_mk'] }}</td>
                    <td rowspan="{{ $rowspan }}">{{ $mk['kode_mk'] }}</td>
                    <td rowspan="{{ $rowspan }}">{{ $mk['nama_mk'] }}</td>
                    <td class="text-center" rowspan="{{ $rowspan }}">{{ $mk['sks_mk'] }}</td>
                    @if($mk['details']->count())
                        @php $first = $mk['details']->first(); @endphp
                        <td>
                            <span class="badge {{ $first['kode_cpl']!='-' ? 'badge-amber' : 'badge-gray' }}">{{ $first['kode_cpl'] }}</span>
                        </td>
                        <td>
                            <span class="badge {{ $first['kode_cpmk']!='-' ? 'badge-amber' : 'badge-gray' }}">{{ $first['kode_cpmk'] }}</span>
                        </td>
                        <td class="text-center">{{ number_format($first['skor_maks'],0) }}</td>
                        <td class="text-center">{{ number_format($first['nilai_perkuliahan'],1) }}</td>
                    @else
                        <td colspan="4" class="text-center small">Tidak ada data CPMK/CPL</td>
                    @endif
                </tr>
                @foreach($mk['details']->slice(1) as $detail)
                    <tr>
                        <td>
                            <span class="badge {{ $detail['kode_cpl']!='-' ? 'badge-amber' : 'badge-gray' }}">{{ $detail['kode_cpl'] }}</span>
                        </td>
                        <td>
                            <span class="badge {{ $detail['kode_cpmk']!='-' ? 'badge-amber' : 'badge-gray' }}">{{ $detail['kode_cpmk'] }}</span>
                        </td>
                        <td class="text-center">{{ number_format($detail['skor_maks'],0) }}</td>
                        <td class="text-center">{{ number_format($detail['nilai_perkuliahan'],1) }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

    <div class="mt-4 small">
        Dicetak pada: {{ date('d/m/Y H:i') }}
    </div>
</body>
</html>

