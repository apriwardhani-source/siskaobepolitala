@extends('layouts.admin.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Data Mahasiswa</h1>
                    <p class="mt-2 text-sm text-gray-600">Kelola data mahasiswa</p>
                </div>
                
                <a href="{{ route('admin.mahasiswa.create') }}"
                   class="btn-gradient-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Mahasiswa
                </a>
            </div>
        </div>

        <!-- Main Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
            
            <!-- Toolbar with Filters -->
            <div class="px-6 py-5 border-b border-gray-200 bg-white">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <h2 class="text-lg font-semibold text-gray-900">Daftar Mahasiswa</h2>
                    
                    <!-- Filters -->
                    <div class="flex flex-col sm:flex-row gap-3">
                        <select id="tahunFilter" class="select-modern">
                            <option value="">Semua Tahun</option>
                            @foreach($tahun_angkatans as $tahun)
                                <option value="{{ $tahun->id_tahun }}" {{ $tahun_angkatan == $tahun->id_tahun ? 'selected' : '' }}>
                                    {{ $tahun->tahun }}
                                </option>
                            @endforeach
                        </select>
                        
                        <select id="prodiFilter" class="select-modern">
                            <option value="">Semua Prodi</option>
                            @foreach($prodis as $prodi)
                                <option value="{{ $prodi->kode_prodi }}" {{ $kode_prodi == $prodi->kode_prodi ? 'selected' : '' }}>
                                    {{ $prodi->nama_prodi }}
                                </option>
                            @endforeach
                        </select>
                        
                        <button onclick="filterData()" class="btn-gradient-primary">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                            </svg>
                            Filter
                        </button>
                    </div>
                </div>

                <!-- Filter Info -->
                @if ($tahun_angkatan || $kode_prodi)
                <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex flex-wrap gap-2 items-center">
                        <span class="text-sm text-blue-800 font-medium">Filter aktif:</span>
                        @if ($tahun_angkatan)
                            <span class="badge-modern badge-blue">
                                Tahun: {{ $tahun_angkatans->where('id_tahun', $tahun_angkatan)->first()->tahun ?? $tahun_angkatan }}
                            </span>
                        @endif
                        @if ($kode_prodi)
                            <span class="badge-modern badge-blue">
                                Prodi: {{ $prodis->where('kode_prodi', $kode_prodi)->first()->nama_prodi ?? $kode_prodi }}
                            </span>
                        @endif
                        <a href="{{ route('admin.mahasiswa.index') }}" 
                           class="text-xs text-blue-600 hover:text-blue-800 hover:underline font-medium">
                            Reset filter
                        </a>
                    </div>
                </div>
                @endif
            </div>

            <!-- Content -->
            @if($mahasiswas->isEmpty())
                <!-- Empty State -->
                <div class="empty-state">
                    <svg class="empty-state-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                              d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <h3 class="empty-state-title">Belum Ada Data Mahasiswa</h3>
                    <p class="empty-state-text">
                        Tidak ada data mahasiswa yang tersedia saat ini.
                    </p>
                </div>
            @else
                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="table-modern">
                        <thead>
                            <tr>
                                <th class="w-32">NIM</th>
                                <th>Nama Mahasiswa</th>
                                <th class="w-48">Program Studi</th>
                                <th class="w-32">Tahun Angkatan</th>
                                <th class="w-28">Status</th>
                                <th class="w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mahasiswas as $mhs)
                            <tr>
                                <td class="text-center">
                                    <span class="badge-modern badge-blue font-mono">{{ $mhs->nim }}</span>
                                </td>
                                <td class="font-medium text-gray-900">{{ $mhs->nama_mahasiswa }}</td>
                                <td>{{ $mhs->prodi ? $mhs->prodi->nama_prodi : '-' }}</td>
                                <td class="text-center">{{ $mhs->tahunAngkatan ? $mhs->tahunAngkatan->tahun : '-' }}</td>
                                <td class="text-center">
                                    @php
                                        $statusColors = [
                                            'aktif' => 'badge-green',
                                            'lulus' => 'badge-blue',
                                            'cuti' => 'badge-amber',
                                            'keluar' => 'badge-red'
                                        ];
                                        $colorClass = $statusColors[$mhs->status] ?? 'badge-gray';
                                    @endphp
                                    <span class="badge-modern {{ $colorClass }}">
                                        {{ ucfirst($mhs->status) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{ route('admin.mahasiswa.edit', $mhs->nim) }}" 
                                           class="p-2 text-blue-600 hover:text-blue-900 hover:bg-blue-50 rounded-lg transition-all duration-200"
                                           title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.mahasiswa.destroy', $mhs->nim) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" 
                                                    onclick="return confirm('Yakin ingin menghapus mahasiswa ini?')"
                                                    class="p-2 text-red-600 hover:text-red-900 hover:bg-red-50 rounded-lg transition-all duration-200"
                                                    title="Hapus">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>
    </div>
</div>

@push('scripts')
<script>
function filterData() {
    const tahun = document.getElementById('tahunFilter').value;
    const prodi = document.getElementById('prodiFilter').value;
    
    let url = "{{ route('admin.mahasiswa.index') }}";
    const params = [];
    
    if (tahun) params.push(`tahun_angkatan=${tahun}`);
    if (prodi) params.push(`kode_prodi=${prodi}`);
    
    if (params.length > 0) {
        url += '?' + params.join('&');
    }
    
    window.location.href = url;
}
</script>
@endpush
@endsection
