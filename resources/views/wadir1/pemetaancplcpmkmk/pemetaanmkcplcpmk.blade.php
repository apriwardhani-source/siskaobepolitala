@extends('layouts.wadir1.app')

@section('title', 'Pemetaan MK - CPL - CPMK (Wadir1)')
@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">

            <div class="mb-8">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-diagram-project text-white text-2xl"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Pemetaan MK - CPL - CPMK</h1>
                        <p class="mt-1 text-sm text-gray-600">Matriks pemetaan CPL ↔ CPMK ↔ Mata Kuliah</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 mb-8">
                <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center"><i class="fas fa-filter mr-2"></i>Filter</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Program Studi</label>
                            <select id="prodi" name="kode_prodi"
                                class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                                onchange="updateFilter()">
                                <option value="" {{ empty($kode_prodi) ? 'selected' : '' }} disabled>Pilih Prodi</option>
                                @foreach (($prodis ?? []) as $p)
                                    <option value="{{ $p->kode_prodi }}" {{ ($kode_prodi ?? '')==$p->kode_prodi ? 'selected' : '' }}>
                                        {{ $p->nama_prodi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun Kurikulum</label>
                            <select id="tahun" name="id_tahun"
                                class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                                onchange="updateFilter()">
                                <option value="" {{ empty($id_tahun) ? 'selected' : '' }}>Semua Tahun</option>
                                @foreach (($tahun_tersedia ?? []) as $thn)
                                    <option value="{{ $thn->id_tahun }}" {{ ($id_tahun ?? '')==$thn->id_tahun ? 'selected' : '' }}>
                                        {{ $thn->nama_kurikulum }} - {{ $thn->tahun }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="self-end">
                            <a href="{{ route('wadir1.pemetaancplcpmkmk.pemetaanmkcplcpmk') }}"
                               class="inline-flex items-center px-4 py-2.5 bg-gray-100 text-gray-700 rounded-lg border border-gray-300 hover:bg-gray-200">
                                Reset filter
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            @if (empty($kode_prodi))
                <div class="bg-white rounded-xl shadow border border-gray-200 p-10 text-center mb-8">
                    <div class="flex justify-center mb-4">
                        <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-blue-500 to-purple-600 text-white flex items-center justify-center shadow-lg">
                            <i class="fas fa-filter text-3xl"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800">Pilih Prodi</h3>
                    <p class="text-gray-600 mt-1">Silakan pilih Program Studi terlebih dahulu untuk melihat matriks.</p>
                </div>
            @else
                <div class="overflow-auto border rounded-lg bg-white">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-blue-900 text-white text-center">
                            <tr>
                                <th class="border px-4 py-2">Kode MK</th>
                                <th class="border px-4 py-2">Nama Mata Kuliah</th>
                                @foreach (($semuaCpl ?? []) as $cpl)
                                    <th class="border px-4 py-2 relative group cursor-pointer">
                                        {{ $cpl->kode_cpl }}
                                        <div class="absolute left-1/2 -translate-x-1/2 top-full mt-1 hidden group-hover:block w-64 bg-black text-white text-sm rounded p-2 z-50 text-center shadow-lg">
                                            <div class="bg-gray-600 font-semibold">{{ $cpl->nama_prodi ?? '-' }}</div>
                                            <div class="mt-3 text-justify">{{ $cpl->deskripsi_cpl ?? '-' }}</div>
                                        </div>
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="bg-white text-gray-800">
                            @foreach (($matrix ?? []) as $kodeMk => $mk)
                                <tr>
                                    <td class="border px-4 py-2 align-top text-center">{{ $kodeMk }}</td>
                                    <td class="border px-4 py-2 align-top">{{ $mk['nama'] ?? '' }}</td>
                                    @foreach (($semuaCpl ?? []) as $cpl)
                                        <td class="border px-2 py-2 text-center">
                                            @if (!empty($mk['cpl'][$cpl->kode_cpl]['cpmks']))
                                                @foreach ($mk['cpl'][$cpl->kode_cpl]['cpmks'] as $kodeCpmk)
                                                    <div class="group inline-block relative cursor-pointer px-1">
                                                        <span class="text-sm">{{ $kodeCpmk }}</span>
                                                        <div class="absolute left-1/2 -translate-x-1/2 top-full mt-1 hidden group-hover:block w-64 bg-black text-white text-xs rounded p-2 z-50 text-center shadow-lg">
                                                            <div class="bg-gray-600 font-bold">{{ $prodi->nama_prodi ?? '-' }}</div>
                                                            <div class="mt-2 text-justify">{{ $mk['cpl'][$cpl->kode_cpl]['cpmk_details'][$kodeCpmk]['deskripsi_cpmk'] ?? '-' }}</div>
                                                        </div>
                                                    </div>
                                                    <br>
                                                @endforeach
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>
    </div>

    <script>
        function updateFilter() {
            const prodiSelect = document.getElementById('prodi');
            const tahunSelect = document.getElementById('tahun');

            const kodeProdi = prodiSelect ? prodiSelect.value : '';
            const idTahun = tahunSelect ? tahunSelect.value : '';

            let url = "{{ route('wadir1.pemetaancplcpmkmk.pemetaanmkcplcpmk') }}";
            let params = [];

            if (kodeProdi) params.push('kode_prodi=' + encodeURIComponent(kodeProdi));
            if (idTahun) params.push('id_tahun=' + encodeURIComponent(idTahun));

            if (params.length > 0) url += '?' + params.join('&');
            window.location.href = url;
        }
    </script>
@endsection

