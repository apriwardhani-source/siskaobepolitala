@extends('layouts.admin.app')

@section('title', 'Pemetaan MK - CPL - CPMK (Admin)')
@section('content')
    <div class="min-h-screen bg-gray-50 py-6 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">

           
            <div class="mb-8">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-diagram-project text-white text-2xl"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Pemetaan MK - CPL - CPMK</h1>
                        <p class="mt-1 text-sm text-gray-600">Matriks pemetaan CPL ↔ CPMK ↔ Mata Kuliah (mode baca saja)</p>
                    </div>
                </div>
            </div>

            <!-- Kartu Filter -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 mb-8">
                <div class="bg-blue-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-filter mr-2"></i>Filter
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-university text-blue-500 mr-1"></i>
                                Program Studi
                            </label>
                            <select id="prodi" name="kode_prodi"
                                    class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                <option value="" {{ empty($kode_prodi) ? 'selected' : '' }} disabled>Pilih Prodi</option>
                                @foreach (($prodis ?? []) as $p)
                                    <option value="{{ $p->kode_prodi }}" {{ ($kode_prodi ?? '')==$p->kode_prodi ? 'selected' : '' }}>
                                        {{ $p->nama_prodi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-calendar text-green-500 mr-1"></i>
                                Tahun Kurikulum
                            </label>
                            <select id="tahun" name="id_tahun"
                                    class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                <option value="" {{ empty($id_tahun) ? 'selected' : '' }}>Semua Tahun</option>
                                @foreach (($tahun_tersedia ?? []) as $thn)
                                    <option value="{{ $thn->id_tahun }}" {{ ($id_tahun ?? '')==$thn->id_tahun ? 'selected' : '' }}>
                                        {{ $thn->nama_kurikulum }} - {{ $thn->tahun }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-end space-x-3">
                            <button type="button"
                                    onclick="updateFilter()"
                                    class="inline-flex items-center px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                                <i class="fas fa-search mr-2"></i>
                                Tampilkan Data
                            </button>
                            {{-- Jika nanti ada route export untuk admin, tombol Export Excel bisa ditambahkan di sini --}}
                        </div>
                    </div>
                </div>
            </div>

            @php
                $isFiltered = !empty($kode_prodi) || !empty($id_tahun);
            @endphp

            @if(!$isFiltered)
                <div class="bg-white rounded-xl shadow border border-gray-200 p-10 text-center mb-8">
                    <div class="flex justify-center mb-4">
                        <div class="w-20 h-20 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-lg">
                            <i class="fas fa-filter text-3xl"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800">Pilih Filter</h3>
                    <p class="text-gray-600 mt-1">Silakan pilih program studi dan tahun untuk menampilkan matriks pemetaan.</p>
                </div>
            @else
                @if ($matrix === null || empty($matrix))
                    <div class="bg-white rounded-xl shadow border border-gray-200 p-8 text-center mb-8">
                        <div class="flex justify-center mb-4">
                            <div class="w-16 h-16 rounded-full bg-yellow-400 text-white flex items-center justify-center shadow">
                                <i class="fas fa-exclamation-triangle text-2xl"></i>
                            </div>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Belum Ada Data Pemetaan</h3>
                        <p class="text-gray-600 mt-1">Data pemetaan MK - CPL - CPMK belum tersedia untuk filter yang dipilih.</p>
                    </div>
                @else
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
                        <div class="px-6 py-4 bg-blue-50 border-b border-blue-100">
                            <p class="text-sm text-blue-800">
                                <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                                <strong>Tip:</strong> Arahkan cursor pada kode CPL atau kode CPMK untuk melihat deskripsi lengkap.
                            </p>
                        </div>

                        <div class="overflow-auto border">
                            <table class="min-w-full divide-y divide-gray-200 text-sm">
                                <thead class="bg-gradient-to-r from-gray-700 to-gray-800 text-white text-center">
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
                                        <tr class="hover:bg-blue-50 transition-colors duration-150">
                                            <td class="border px-4 py-3 align-top text-center">
                                                <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold bg-gradient-to-r from-purple-500 to-purple-600 text-white shadow-sm">
                                                    {{ $kodeMk }}
                                                </span>
                                            </td>
                                            <td class="border px-4 py-3 align-top">
                                                <div class="font-medium text-gray-900">{{ $mk['nama'] ?? '' }}</div>
                                            </td>
                                            @foreach (($semuaCpl ?? []) as $cpl)
                                                <td class="border px-2 py-2 text-center align-top">
                                                    @if (!empty($mk['cpl'][$cpl->kode_cpl]['cpmks']))
                                                        @foreach ($mk['cpl'][$cpl->kode_cpl]['cpmks'] as $kodeCpmk)
                                                            <div class="group inline-block relative cursor-pointer px-1 mb-1">
                                                                <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-sm">
                                                                    {{ $kodeCpmk }}
                                                                </span>
                                                                <div class="absolute left-1/2 -translate-x-1/2 top-full mt-1 hidden group-hover:block w-64 bg-black text-white text-xs rounded p-2 z-50 text-center shadow-lg">
                                                                    <div class="bg-gray-600 font-bold">{{ $prodi->nama_prodi ?? '-' }}</div>
                                                                    <div class="mt-2 text-justify">{{ $mk['cpl'][$cpl->kode_cpl]['cpmk_details'][$kodeCpmk]['deskripsi_cpmk'] ?? '-' }}</div>
                                                                </div>
                                                            </div>
                                                            <br>
                                                        @endforeach
                                                    @else
                                                        <span class="text-gray-300 text-xs">-</span>
                                                    @endif
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>

    <script>
        function updateFilter() {
            const prodiSelect = document.getElementById('prodi');
            const tahunSelect = document.getElementById('tahun');

            const kodeProdi = prodiSelect.value;
            const idTahun = tahunSelect.value;

            let url = "{{ route('admin.pemetaancplcpmkmk.pemetaanmkcplcpmk') }}";
            let params = [];

            if (kodeProdi) params.push('kode_prodi=' + encodeURIComponent(kodeProdi));
            if (idTahun) params.push('id_tahun=' + encodeURIComponent(idTahun));

            if (params.length > 0) url += '?' + params.join('&');
            window.location.href = url;
        }
    </script>
@endsection
