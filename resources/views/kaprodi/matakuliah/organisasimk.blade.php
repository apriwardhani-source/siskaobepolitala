@extends('layouts.kaprodi.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Organisasi Mata Kuliah</h1>
            <p class="mt-2 text-sm text-gray-600">Distribusi mata kuliah per semester</p>
        </div>

        <!-- Main Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
            <!-- Header Filter -->
            <div class="bg-blue-600 px-6 py-4 flex items-center justify-between text-white">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 rounded-lg bg-blue-500 flex items-center justify-center shadow">
                        <i class="fas fa-filter text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold">Filter Organisasi MK</h2>
                        <p class="text-xs text-blue-100">Pilih tahun kurikulum untuk melihat distribusi MK per semester.</p>
                    </div>
                </div>
            </div>

            <!-- Toolbar -->
            <div class="px-6 py-5 border-b border-gray-200 bg-white">
                <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Distribusi per Semester</h2>
                    </div>
                    
                    <!-- Filter + Actions -->
                    <div class="flex flex-col sm:flex-row gap-3 items-stretch sm:items-end">
                        <div class="w-64">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">
                                <i class="fas fa-calendar text-green-500 mr-1"></i>
                                Tahun Kurikulum
                            </label>
                            <select id="tahun" name="id_tahun"
                                class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg 
                                       focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                <option value="" {{ empty($id_tahun) ? 'selected' : '' }}>Semua Tahun</option>
                                @if (isset($tahun_tersedia))
                                    @foreach ($tahun_tersedia as $thn)
                                        <option value="{{ $thn->id_tahun }}" {{ $id_tahun == $thn->id_tahun ? 'selected' : '' }}>
                                            {{ $thn->nama_kurikulum }} - {{ $thn->tahun }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="flex gap-3">
                            <button type="button" onclick="updateFilter()"
                                    class="inline-flex items-center px-6 py-2.5 bg-blue-600 hover:bg-blue-700 
                                           text-white text-sm font-semibold rounded-lg shadow-md hover:shadow-lg 
                                           transform hover:scale-105 transition-all duration-200">
                                <i class="fas fa-search mr-2"></i>
                                Tampilkan Data
                            </button>
                            <a href="{{ route('kaprodi.export.excel', ['id_tahun' => $id_tahun ?? request('id_tahun')]) }}"
                               class="inline-flex items-center px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
                                <i class="fas fa-file-excel mr-2"></i>
                                Export Excel
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Filter Info -->
                @if ($id_tahun)
                <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex flex-wrap gap-2 items-center">
                        <span class="text-sm text-blue-800 font-medium">Filter aktif:</span>
                        @php
                            $selected_tahun = $tahun_tersedia->where('id_tahun', $id_tahun)->first();
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                            Tahun: {{ $selected_tahun ? $selected_tahun->nama_kurikulum . ' - ' . $selected_tahun->tahun : $id_tahun }}
                        </span>
                        <a href="{{ route('kaprodi.matakuliah.organisasimk') }}" 
                           class="text-xs text-blue-600 hover:text-blue-800 hover:underline font-medium">
                            Reset filter
                        </a>
                    </div>
                </div>
                @endif
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-gray-700 to-gray-800">
                        <tr>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider w-40">Semester</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider w-32">Total SKS</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider w-32">Jumlah MK</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-100 uppercase tracking-wider">Mata Kuliah</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php
                            $totalSks = 0;
                            $totalMk = 0;
                        @endphp

                        @for ($i = 1; $i <= 8; $i++)
                            @php
                                $data = $organisasiMK->get($i, [
                                    'semester_mk' => $i,
                                    'sks_mk' => 0,
                                    'jumlah_mk' => 0,
                                    'nama_mk' => [],
                                ]);

                                $totalSks += $data['sks_mk'];
                                $totalMk += $data['jumlah_mk'];
                            @endphp
                            <tr class="hover:bg-blue-50 transition-colors duration-150 {{ $i % 2 == 0 ? 'bg-gray-50' : 'bg-white' }}">
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-blue-100 text-blue-800">
                                        Semester {{ $data['semester_mk'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="text-lg font-bold text-gray-900">{{ $data['sks_mk'] }}</span>
                                    <span class="text-xs text-gray-500 ml-1">SKS</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold
                                                 {{ $data['jumlah_mk'] > 0 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                        {{ $data['jumlah_mk'] }} MK
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if (count($data['nama_mk']) > 0)
                                        <div class="flex flex-wrap gap-2">
                                            @foreach ($data['nama_mk'] as $kode)
                                                <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium bg-purple-100 text-purple-800 border border-purple-200">
                                                    {{ $kode }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-sm italic">Tidak ada mata kuliah</span>
                                    @endif
                                </td>
                            </tr>
                        @endfor

                        <!-- Total Row -->
                        <tr class="bg-gradient-to-r from-gray-800 to-gray-900 text-white font-bold">
                            <td class="px-6 py-5 text-center text-base uppercase tracking-wider">
                                <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd"/>
                                </svg>
                                Total
                            </td>
                            <td class="px-6 py-5 text-center">
                                <span class="text-xl">{{ $totalSks }}</span>
                                <span class="text-sm ml-1">SKS</span>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <span class="text-xl">{{ $totalMk }}</span>
                                <span class="text-sm ml-1">MK</span>
                            </td>
                            <td class="px-6 py-5"></td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
function updateFilter() {
    const tahunSelect = document.getElementById('tahun');
    const idTahun = tahunSelect.value;

    let url = "{{ route('kaprodi.matakuliah.organisasimk') }}";

    if (idTahun) {
        url += '?id_tahun=' + encodeURIComponent(idTahun);
    }

    window.location.href = url;
}
</script>
@endpush
@endsection
