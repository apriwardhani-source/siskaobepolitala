@extends('layouts.app')

@section('content')
    <div class="bg-white p-4 md:p-6 lg:p-8 rounded-lg shadow-md mx-2 md:mx-0">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Pemetaan CPL - MK</h1>
            <hr class="border-t-2 md:border-t-4 border-black my-3 md:my-4 mx-auto">
        </div>

        @if (session('success'))
            <div id="alert"
                class="bg-green-500 text-white px-4 py-2 rounded-md mb-6 text-center relative max-w-4xl mx-auto">
                <span class="font-bold">{{ session('success') }}</span>
                <button onclick="document.getElementById('alert').style.display='none'"
                    class="absolute top-1 right-3 text-white font-bold text-lg">
                    &times;
                </button>
            </div>
        @endif

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <div class="flex flex-col md:flex-row gap-4 w-full md:w-auto">
                <select id="prodi" name="kode_prodi"
                    class="w-full md:w-64 border border-black px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                    onchange="updateFilter()">
                    <option value="" {{ empty($kode_prodi) ? 'selected' : '' }} disabled>Pilih Prodi</option>
                    @foreach ($prodis as $prodi)
                        <option value="{{ $prodi->kode_prodi }}" {{ $kode_prodi == $prodi->kode_prodi ? 'selected' : '' }}>
                            {{ $prodi->nama_prodi }}
                        </option>
                    @endforeach
                </select>

                <select id="tahun" name="id_tahun"
                    class="w-full md:w-64 border border-black px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                    onchange="updateFilter()">
                    <option value="" {{ empty($id_tahun) ? 'selected' : '' }}>Semua Tahun</option>
                    @foreach ($tahun_tersedia as $thn)
                        <option value="{{ $thn->id_tahun }}" {{ $id_tahun == $thn->id_tahun ? 'selected' : '' }}>
                            {{ $thn->nama_kurikulum }} - {{ $thn->tahun }}
                        </option>
                    @endforeach
                </select>
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
                            $selected_tahun = $tahun_tersedia->firstWhere('id_tahun', $id_tahun);
                        @endphp
                        <span
                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            Tahun:
                            {{ $selected_tahun ? $selected_tahun->nama_kurikulum . ' - ' . $selected_tahun->tahun : $id_tahun }}
                        </span>
                    @endif
                    <a href="{{ route('admin.pemetaancplmk.index') }}"
                        class="text-xs text-blue-600 hover:text-blue-800 underline">
                        Reset filter
                    </a>
                </div>
            </div>
        @endif

        @if ($kode_prodi)
            <div class="bg-white rounded-lg shadow">
                @if ($cpls->isEmpty())
                    <div class="p-8 text-center text-gray-600">
                        <strong>Data belum dibuat untuk prodi ini.</strong>
                    </div>
                @else
                    <style>
                        input[type="checkbox"]:checked::before {
                            content: "✓";
                            color: white;
                            font-size: 1rem;
                            position: absolute;
                            top: 50%;
                            left: 50%;
                            transform: translate(-50%, -50%);
                        }
                    </style>

                    <div class="overflow-x-auto w-full">
                        <table class="w-full border border-black shadow-md rounded-lg">
                            <thead class="bg-green-800 text-white">
                                <tr>
                                    <th class="px-4 py-2 text-left"></th>
                                    @foreach ($mks as $mk)
                                        <th class="px-2 py-2 relative group whitespace-nowrap">
                                            <span class="cursor-help">{{ $mk->kode_mk }}</span>
                                            <div
                                                class="absolute top-full mb-4 left-1/2 -translate-x-1/2 hidden group-hover:block w-64 bg-black text-white text-sm rounded p-2 z-50 text-center shadow-lg break-words">
                                                <div class="bg-gray-600 rounded-t px-2 py-1 font-bold">
                                                    {{ $mk->nama_prodi }}
                                                </div>
                                                <div class="mt-3 px-2 text-center">
                                                    {{ $mk->nama_mk }}
                                                </div>
                                            </div>
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cpls as $index => $cpl)
                                    <tr
                                        class="{{ $index % 2 == 0 ? 'bg-gray-100' : 'bg-white' }} hover:bg-gray-200 border">
                                        <td class="px-4 py-2 relative group whitespace-nowrap">
                                            <span class="cursor-help">{{ $cpl->kode_cpl }}</span>
                                            <div
                                                class="absolute top-full left-0 ml-4 mb-4 hidden group-hover:block w-64 bg-black text-white text-sm rounded p-2 z-50 text-center shadow-lg break-words">
                                                <div class="bg-gray-600 rounded-t px-2 py-1 font-bold">
                                                    {{ $prodiByCpl[$cpl->id_cpl] ?? 'Program Studi Tidak Ditemukan' }}
                                                </div>
                                                <div class="mt-3 px-2 text-justify whitespace-normal">
                                                    {{ $cpl->deskripsi_cpl }}
                                                </div>
                                            </div>
                                        </td>
                                        @foreach ($mks as $mk)
                                            <td class="px-4 py-2 text-center">
                                                <input type="checkbox" disabled
                                                    {{ isset($relasi[$mk->kode_mk]) && in_array($cpl->id_cpl, $relasi[$mk->kode_mk]->pluck('id_cpl')->toArray()) ? 'checked' : '' }}
                                                    class="h-5 w-5 mx-auto appearance-none rounded border-2 border-blue-600 bg-white checked:bg-blue-600 checked:border-blue-600 disabled:opacity-100 disabled:cursor-default relative">
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                @endif
                <p class="mt-3 italic text-red-500">*arahkan cursor pada kode cpl atau kode mk untuk melihat deskripsi*</p>
            </div>
        @else
            <div class="bg-white rounded-lg shadow overflow-hidden mt-1">
                <div class="p-8 text-center text-gray-600">
                    Silakan pilih prodi terlebih dahulu.
                </div>
            </div>
        @endif
    </div>

    <script>
        function updateFilter() {
            const prodiSelect = document.getElementById('prodi');
            const tahunSelect = document.getElementById('tahun');

            const kodeProdi = prodiSelect.value;
            const idTahun = tahunSelect.value;

            let url = "{{ route('admin.pemetaancplmk.index') }}";
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

            window.location.href = url;
        }
    </script>
@endsection
