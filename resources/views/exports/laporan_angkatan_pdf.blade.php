<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Angkatan</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: center; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">📑 Laporan CPL per Angkatan</h2>
    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Hasil</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporan as $row)
                <tr>
                    <td>{{ $row[0] }}</td>
                    <td>{{ $row[1] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
