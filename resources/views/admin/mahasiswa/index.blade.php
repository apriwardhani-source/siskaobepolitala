@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Data Mahasiswa</h2>
    
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="tahunFilter">Tahun Angkatan</label>
            <select id="tahunFilter" class="form-control">
                <option value="">Semua Tahun</option>
                @foreach($tahun_angkatans as $tahun)
                    <option value="{{ $tahun->id_tahun }}" {{ $tahun_angkatan == $tahun->id_tahun ? 'selected' : '' }}>{{ $tahun->tahun }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label for="prodiFilter">Program Studi</label>
            <select id="prodiFilter" class="form-control">
                <option value="">Semua Prodi</option>
                @foreach($prodis as $prodi)
                    <option value="{{ $prodi->kode_prodi }}" {{ $kode_prodi == $prodi->kode_prodi ? 'selected' : '' }}>{{ $prodi->nama_prodi }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label>&nbsp;</label>
            <button class="btn btn-primary form-control" onclick="filterData()">Filter</button>
        </div>
        <div class="col-md-3 text-right">
            <label>&nbsp;</label><br>
            <a href="{{ route('admin.mahasiswa.create') }}" class="btn btn-success">Tambah Mahasiswa</a>
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama Mahasiswa</th>
                    <th>Program Studi</th>
                    <th>Tahun Angkatan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mahasiswas as $mhs)
                <tr>
                    <td>{{ $mhs->nim }}</td>
                    <td>{{ $mhs->nama_mahasiswa }}</td>
                    <td>{{ $mhs->prodi ? $mhs->prodi->nama_prodi : '-' }}</td>
                    <td>{{ $mhs->tahunAngkatan ? $mhs->tahunAngkatan->tahun : '-' }}</td>
                    <td>
                        <span class="badge badge-{{ $mhs->status == 'aktif' ? 'success' : ($mhs->status == 'lulus' ? 'primary' : ($mhs->status == 'cuti' ? 'warning' : 'danger')) }}">
                            {{ ucfirst($mhs->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.mahasiswa.edit', $mhs->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.mahasiswa.destroy', $mhs->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus mahasiswa ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data mahasiswa</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
function filterData() {
    const tahun = document.getElementById('tahunFilter').value;
    const prodi = document.getElementById('prodiFilter').value;
    
    let url = "{{ route('admin.mahasiswa.index') }}";
    const params = [];
    
    if (tahun) params.push('tahun_angkatan=' + tahun);
    if (prodi) params.push('kode_prodi=' + prodi);
    
    if (params.length > 0) {
        url += '?' + params.join('&');
    }
    
    window.location.href = url;
}
</script>
@endsection