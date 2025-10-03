<!-- resources/views/admin/manage_matkul.blade.php -->

@extends('layouts.app') {{-- kalau kamu pakai layout utama --}}

@section('content')
    <div class="container">
        <h1>Manajemen Mata Kuliah</h1>

        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>SKS</th>
                    <th>Dosen ID</th>
                </tr>
            </thead>
            <tbody>
                @foreach($matakuliahs as $mk)
                    <tr>
                        <td>{{ $mk->kode }}</td>
                        <td>{{ $mk->nama }}</td>
                        <td>{{ $mk->sks }}</td>
                        <td>{{ $mk->dosen_id }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
