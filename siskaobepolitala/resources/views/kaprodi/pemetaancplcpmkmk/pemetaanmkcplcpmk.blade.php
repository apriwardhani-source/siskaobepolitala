@extends('layouts.kaprodi.app')
@section('content')
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 mx-2 md:mx-0">
        <!-- Header Filter -->
        <div class="bg-blue-600 px-6 py-4 flex items-center justify-between text-white">
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 rounded-lg bg-blue-500 flex items-center justify-center shadow">
                    <i class="fas fa-filter text-white"></i>
                </div>
                <div>
                    <h1 class="text-lg font-bold">Filter Pemetaan MK–CPL–CPMK</h1>
                    <p class="text-xs text-blue-100">Pilih prodi dan tahun kurikulum untuk menampilkan matriks pemetaan.</p>
                </div>
            </div>
        </div>
        <div class="p-4 md:p-6 lg:p-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-6 gap-4">
                <div class="flex flex-col md:flex-row gap-4 w-full md:w-auto">
                    <div class="flex flex-col md:flex-row gap-4 w-full md:w-auto">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            <i class="fas fa-university text-blue-500 mr-1"></i>
                            Program Studi
                        </label>
                        <select id="prodi" name="kode_prodi"
                            class="w-full md:w-64 border border-gray-300 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="" {{ empty($kode_prodi) ? 'selected' : '' }} disabled>Pilih Prodi</option>
                            @foreach ($prodis as $prodi)
                                <option value="{{ $prodi->kode_prodi }}"
                                    {{ $kode_prodi == $prodi->kode_prodi ? 'selected' : '' }}>
                                    {{ $prodi->nama_prodi }}
                                </option>
                            @endforeach
                        </select>

                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            <i class="fas fa-calendar text-green-500 mr-1"></i>
                            Tahun Kurikulum
                        </label>
                        <select id="tahun" name="id_tahun"
                            class="w-full md:w-64 border border-gray-300 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="" {{ empty($id_tahun) ? 'selected' : '' }}>Semua Tahun</option>
                            @if (isset($tahun_tersedia))
                                @foreach ($tahun_tersedia as $thn)
                                    <option value="{{ $thn->id_tahun }}"
                                        {{ $id_tahun == $thn->id_tahun ? 'selected' : '' }}>
                                        {{ $thn->nama_kurikulum }} - {{ $thn->tahun }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
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

            @if ($kode_prodi || $id_tahun)
                <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-md">
                    <div class="flex flex-wrap gap-2 items-center">
                        <span class="text-sm text-blue-800 font-medium">Filter aktif:</span>
                        @if ($kode_prodi)
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                Prodi: {{ $prodis->where('kode_prodi', $kode_prodi)->first()->nama_prodi ?? $kode_prodi }}
                            </span>
                        @endif
                        @if ($id_tahun)
                            @php
                                $selected_tahun = $tahun_tersedia->where('id_tahun', $id_tahun)->first();
                            @endphp
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                Tahun:
                                {{ $selected_tahun ? $selected_tahun->nama_kurikulum . ' - ' . $selected_tahun->tahun : $id_tahun }}
                            </span>
                        @endif
                        <a href="{{ route('kaprodi.pemetaancplcpmkmk.pemetaanmkcplcpmk') }}"
                            class="text-xs text-blue-600 hover:text-blue-800 underline">
                            Reset filter
                        </a>
                    </div>
                </div>
            @endif

            @if (empty($kode_prodi))
                <div class="bg-white rounded-xl shadow border border-gray-200 p-10 text-center mb-4">
                    <div class="flex justify-center mb-4">
                        <div class="w-20 h-20 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-lg">
                            <i class="fas fa-filter text-3xl"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800">Pilih Filter</h3>
                    <p class="text-gray-600 mt-1">Silakan pilih program studi dan tahun kurikulum untuk menampilkan matriks pemetaan.</p>
                </div>
            @else
                <div class="overflow-auto border rounded-lg bg-white">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-green-800 text-white text-center">
                            <tr>
                                <th class="border px-4 py-2 text-xs font-semibold uppercase tracking-wider">Kode MK</th>
                                <th class="border px-4 py-2 text-xs font-semibold uppercase tracking-wider">Nama Mata Kuliah</th>
                                @foreach ($semuaCpl as $cpl)
                                    <th class="border px-4 py-2 text-xs font-semibold uppercase tracking-wider relative group cursor-pointer">
                                        {{ $cpl->kode_cpl }}
                                        <div
                                            class="absolute left-1/2 -translate-x-1/2 top-full mt-1 hidden group-hover:block w-64 bg-black text-white text-xs rounded p-2 z-50 text-center shadow-lg">
                                            <div class="bg-gray-600 font-semibold">{{ $cpl->nama_prodi ?? '-' }}</div>
                                            <div class="mt-3 text-justify">{{ $cpl->deskripsi_cpl ?? '-' }}</div>
                                        </div>
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="bg-white text-gray-800">
                            @foreach ($matrix as $kodeMk => $mk)
                                <tr class="hover:bg-blue-50 transition-colors duration-150">
                                    <td class="border px-4 py-3 align-top text-center">
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold bg-gradient-to-r from-purple-500 to-purple-600 text-white shadow-sm">
                                            {{ $kodeMk }}
                                        </span>
                                    </td>
                                    <td class="border px-4 py-3 align-top">
                                        <div class="font-medium text-gray-900">{{ $mk['nama'] ?? '' }}</div>
                                    </td>
                                    @foreach ($semuaCpl as $cpl)
                                        <td class="border px-2 py-2 text-center align-top">
                                            @if (!empty($mk['cpl'][$cpl->kode_cpl]['cpmks']))
                                                @foreach ($mk['cpl'][$cpl->kode_cpl]['cpmks'] as $kodeCpmk)
                                                    <div class="group inline-block relative cursor-pointer px-1 mb-1">
                                                        <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-sm">
                                                            {{ $kodeCpmk }}
                                                        </span>
                                                        <div
                                                            class="absolute left-1/2 -translate-x-1/2 top-full mt-1 hidden group-hover:block w-64 bg-black text-white text-xs rounded p-2 z-50 text-center shadow-lg">
                                                            <div class="bg-gray-600 font-bold">
                                                                {{ $mk['cpl'][$cpl->kode_cpl]['cpmk_details'][$kodeCpmk]['nama_prodi'] ?? '-' }}
                                                            </div>
                                                            <div class="mt-2 text-justify">
                                                                {{ $mk['cpl'][$cpl->kode_cpl]['cpmk_details'][$kodeCpmk]['deskripsi_cpmk'] ?? '-' }}
                                                            </div>
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
            @endif
        </div>
    </div>
    <script>
        function updateFilter() {
            const prodiSelect = document.getElementById('prodi');
            const tahunSelect = document.getElementById('tahun');

            const kodeProdi = prodiSelect.value;
            const idTahun = tahunSelect.value;

            // Buat URL dengan parameter yang sesuai
            let url = "{{ route('kaprodi.pemetaancplcpmkmk.pemetaanmkcplcpmk') }}";
            let params = [];

            if (kodeProdi) {
                params.push('kode_prodi=' + encodeURIComponent(kodeProdi));
            }

            if (idTahun) {
                params.push('id_tahun=' + encodeURIComponent(idTahun));
            }

            if (params.length > 0) {
                url += '?' + params.join('&');
            }

            // Redirect ke URL dengan parameter yang benar
            window.location.href = url;
        }
    </script>
@endsection
