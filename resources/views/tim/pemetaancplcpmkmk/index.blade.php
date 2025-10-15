@extends('layouts.tim.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-full mx-auto">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Pemetaan CPL - CPMK - MK</h1>
            <p class="mt-2 text-sm text-gray-600">Pemetaan capaian profil lulusan, capaian pembelajaran mata kuliah, dan mata kuliah</p>
        </div>

        <!-- Main Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
            
            <!-- Toolbar -->
            <div class="px-6 py-5 border-b border-gray-200 bg-white">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900">Matriks Pemetaan</h2>
                    
                    <!-- Filter -->
                    <div class="w-64">
                        <select id="tahun" name="id_tahun" onchange="updateFilter()"
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
                        <a href="{{ route('tim.pemetaancplcpmkmk.index') }}" 
                           class="text-xs text-blue-600 hover:text-blue-800 hover:underline font-medium">
                            Reset filter
                        </a>
                    </div>
                </div>
                @endif
            </div>

            <!-- Content -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-gray-700 to-gray-800">
                        <tr>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-gray-100 uppercase tracking-wider border-r border-gray-600">Kode CPL</th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-gray-100 uppercase tracking-wider border-r border-gray-600">Deskripsi CPL</th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-gray-100 uppercase tracking-wider border-r border-gray-600">Kode CPMK</th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-gray-100 uppercase tracking-wider border-r border-gray-600">Deskripsi CPMK</th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-gray-100 uppercase tracking-wider">Mata Kuliah</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($matrix as $kode_cpl => $cpl)
                            @php
                                $rowspan = count($cpl['cpmk']);
                                $first = true;
                            @endphp
                            @foreach ($cpl['cpmk'] as $kode_cpmk => $cpmk)
                                <tr class="hover:bg-blue-50 transition-colors duration-150">
                                    @if ($first)
                                        <td class="px-4 py-3 border-r border-gray-200 align-top" rowspan="{{ $rowspan }}">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                                {{ $kode_cpl }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 border-r border-gray-200 text-sm text-gray-700 align-top" rowspan="{{ $rowspan }}">
                                            {{ $cpl['deskripsi'] }}
                                        </td>
                                        @php $first = false; @endphp
                                    @endif
                                    <td class="px-4 py-3 border-r border-gray-200">
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-purple-100 text-purple-800">
                                            {{ $kode_cpmk }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 border-r border-gray-200 text-sm text-gray-700">
                                        {{ $cpmk['deskripsi'] }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        @foreach (array_unique($cpmk['mk']) as $mk)
                                            <div class="mb-1">
                                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-800">
                                                    {{ $mk }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
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

    let url = "{{ route('tim.pemetaancplcpmkmk.index') }}";
    
    if (idTahun) {
        url += '?id_tahun=' + encodeURIComponent(idTahun);
    }

    window.location.href = url;
}
</script>
@endpush
@endsection
