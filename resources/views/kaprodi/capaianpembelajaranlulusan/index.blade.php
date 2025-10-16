@extends('layouts.kaprodi.app')

@section('content')
    <div class="bg-white rounded-lg shadow-md mr-10 ml-10">
        <h2 class="text-2xl font-bold text-gray-700 mb-4 text-center">Daftar Capaian Pembelajaran Lulusan</h2>
        <hr class="border-t-4 border-black my-8">
        @if (session('success'))
            <div id="alert" class="bg-green-500 text-white px-4 py-2 rounded-md mb-4 text-center relative">
                <span class="font-bold">{{ session('success') }}</span>
                <button onclick="document.getElementById('alert').style.display='none'"
                    class="absolute top-1 right-3 text-white font-bold text-lg">
                    &times;
                </button>
            </div>
        @endif

        @if (session('sukses'))
            <div id="alert" class="bg-red-500 text-white px-4 py-2 rounded-md mb-4 text-center relative">
                <span class="font-bold">{{ session('sukses') }}</span>
                <button onclick="document.getElementById('alert').style.display='none'"
                    class="absolute top-1 right-3 text-white font-bold text-lg">
                    &times;
                </button>
            </div>
        @endif

        <div class="flex justify-between mb-4">
            <!-- Filter Tahun -->
            <select id="tahun" name="id_tahun"
                class="border border-black px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                onchange="updateFilter()">
                <option value="" {{ empty($id_tahun) ? 'selected' : '' }}>Semua Tahun</option>
                @if (isset($tahun_tersedia))
                    @foreach ($tahun_tersedia as $thn)
                        <option value="{{ $thn->id_tahun }}" {{ $id_tahun == $thn->id_tahun ? 'selected' : '' }}>
                            {{ $thn->nama_kurikulum }} - {{ $thn->tahun }}
                        </option>
                    @endforeach
                @endif
            </select>
            <div class="ml-auto justify-between">
                <input type="text" id="search" placeholder="Search..."
                    class="border border-black px-3 py-2 rounded-md">
            </div>
        </div>
        <!-- Filter Info -->
        @if ($id_tahun)
            <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-md">
                <div class="flex flex-wrap gap-2 items-center">
                    <span class="text-sm text-blue-800 font-medium">Filter aktif:</span>
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
                    <a href="{{ route('kaprodi.capaianpembelajaranlulusan.index') }}"
                        class="text-xs text-blue-600 hover:text-blue-800 underline">
                        Reset filter
                    </a>
                </div>
            </div>
        @endif
        <div class="bg-white shadow-lg overflow-hidden">
            <table class="w-full border border-black shadow-md rounded-lg overflow-hidden">
                <thead class="bg-green-800 text-white border-b">
                    <tr>
                        <th class="py-3 px-4 min-w-[10px] text-center font-bold uppercase ">No.</th>
                        <th class="py-3 px-6 min-w-[10px] text-center font-bold uppercase">Kode CPL</th>
                        <th class="py-3 px-6 min-w-[10px] text-center font-bold uppercase">Deskripsi CPL</th>
                        <th class="py-3 px-6 min-w-[10px] text-center font-bold uppercase">Status CPL</th>
                        <th class="py-3 px-6 font-bold uppercase min-w-[10px] text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($capaianpembelajaranlulusans as $index => $capaianpembelajaranlulusan)
                        <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : 'bg-white' }} hover:bg-gray-200 border-b">
                            <td class="py-3 px-6 min-w-[10px] text-center">{{ $index + 1 }}</td>
                            <td class="py-3 px-6 min-w-[10px] text-center">{{ $capaianpembelajaranlulusan->kode_cpl }}</td>
                            <td class="py-3 px-6 min-w-[10px] text-justify">
                                {{ $capaianpembelajaranlulusan->deskripsi_cpl }}</td>
                            <td class="py-3 px-6 min-w-[10px] text-center">{{ $capaianpembelajaranlulusan->status_cpl }}
                            </td>
                            <td class="py-3 px-6 min-w-[10px] flex justify-center items-center space-x-2">
                                <a href="{{ route('kaprodi.capaianpembelajaranlulusan.detail', $capaianpembelajaranlulusan->id_cpl) }}"
                                    class="bg-gray-600 font-bold text-white px-5 py-3 rounded-md hover:bg-gray-800">🛈</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <script>
            function updateFilter() {
                const tahunSelect = document.getElementById('tahun');
                const idTahun = tahunSelect.value;

                let url = "{{ route('kaprodi.capaianpembelajaranlulusan.index') }}";

                if (idTahun) {
                    url += '?id_tahun=' + encodeURIComponent(idTahun);
                }

                window.location.href = url;
            }
        </script>
    @endsection
