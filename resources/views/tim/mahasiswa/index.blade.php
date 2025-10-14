@extends('layouts.tim.app')

@section('content')
    <div class="bg-white p-4 md:p-6 lg:p-8 rounded-lg shadow-md mx-2 md:mx-0">
        <div class="text-center mb-6 md:mb-8">
            <h1 class="text-xl md:text-3xl font-bold text-gray-700">Daftar Mahasiswa</h1>
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
                <div class="flex space-x-2">
                    <a href="{{ route('tim.mahasiswa.create') }}"
                        class="bg-green-600 hover:bg-green-800 text-white font-bold px-4 py-2 rounded-md inline-flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                clip-rule="evenodd" />
                        </svg>
                        Tambah Mahasiswa
                    </a>
                </div>

                <div class="flex flex-col md:flex-row gap-4 w-full md:w-auto">
                    <select id="tahun" name="id_tahun"
                        class="w-full md:w-64 border border-black px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                        onchange="updateFilter()">
                        <option value="">Semua Tahun Kurikulum</option>
                        @if (isset($tahun_angkatans))
                            @foreach ($tahun_angkatans as $tahun)
                                <option value="{{ $tahun->id_tahun }}" {{ $tahun_kurikulum == $tahun->id_tahun ? 'selected' : '' }}>
                                    {{ $tahun->tahun }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>

            <!-- Search -->
            <div class="sm:min-w-[250px] w-full sm:w-auto">
                <div
                    class="flex items-center border border-black rounded-md focus-within:ring-2 focus-within:ring-green-500 bg-white">
                    <span class="pl-3 text-gray-400">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" id="search" placeholder="Search..."
                        class="px-3 py-2 w-full focus:outline-none bg-transparent" />
                </div>
            </div>
        </div>

        <!-- Filter Info -->
        @if ($tahun_kurikulum)
            <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-md">
                <div class="flex flex-wrap gap-2 items-center">
                    <span class="text-sm text-blue-800 font-medium">Filter aktif:</span>
                    @if ($tahun_kurikulum)
                        @php
                            $selected_tahun = $tahun_angkatans->where('id_tahun', $tahun_kurikulum)->first();
                        @endphp
                        <span
                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            Tahun Kurikulum: {{ $selected_tahun ? $selected_tahun->tahun : $tahun_kurikulum }}
                        </span>
                    @endif
                    <a href="{{ route('tim.mahasiswa.index') }}"
                        class="text-xs text-blue-600 hover:text-blue-800 underline">
                        Reset filter
                    </a>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow overflow-hidden">
            @if ($mahasiswas->isEmpty())
                <div class="p-8 text-center text-gray-600">
                    Data masih kosong
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-green-800 text-white">
                            <tr>
                                <th class="py-3 px-4 w-10 text-center border border-gray-300">No.</th>
                                <th class="px-4 py-2 text-center w-24 border border-gray-300">NIM</th>
                                <th class="px-4 py-2 text-center w-48 border border-gray-300">Nama Mahasiswa</th>
                                <th class="px-4 py-2 text-center w-40 border border-gray-300">Program Studi</th>
                                <th class="px-4 py-2 text-center w-32 border border-gray-300">Tahun Angkatan</th>
                                <th class="px-4 py-2 text-center w-24 border border-gray-300">Status</th>
                                <th class="px-4 py-2 text-center w-32 border border-gray-300">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($mahasiswas as $index => $mhs)
                                <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : 'bg-white' }} hover:bg-gray-100">
                                    <td class="px-4 py-4 text-center text-sm">{{ $index + 1 }}</td>
                                    <td class="px-4 py-4 text-center text-sm">{{ $mhs->nim }}</td>
                                    <td class="px-4 py-4 text-sm text-justify">{{ $mhs->nama_mahasiswa }}</td>
                                    <td class="px-4 py-4 text-sm text-center">{{ $mhs->prodi ? $mhs->prodi->nama_prodi : '-' }}</td>
                                    <td class="px-4 py-4 text-sm text-center">{{ $mhs->tahunAngkatan ? $mhs->tahunAngkatan->tahun : '-' }}</td>
                                    <td class="px-4 py-4 text-sm text-center">
                                        @if($mhs->status == 'aktif')
                                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded">Aktif</span>
                                        @elseif($mhs->status == 'lulus')
                                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded">Lulus</span>
                                        @elseif($mhs->status == 'cuti')
                                            <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded">Cuti</span>
                                        @else
                                            <span class="bg-red-100 text-red-800 px-2 py-1 rounded">Keluar</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex justify-center space-x-2">
                                            <a href="{{ route('tim.mahasiswa.edit', $mhs->id) }}"
                                                class="bg-blue-600 hover:bg-blue-800 text-white p-2 rounded-md"
                                                title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path
                                                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('tim.mahasiswa.destroy', $mhs->id) }}"
                                                method="POST">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-600 hover:bg-red-800 text-white p-2 rounded-md"
                                                    title="Hapus" onclick="return confirm('Hapus mahasiswa ini?')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                            clip-rule="evenodd" />
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

    <script>
        function updateFilter() {
            const tahunSelect = document.getElementById('tahun');
            const idTahun = tahunSelect.value;

            let url = "{{ route('tim.mahasiswa.index') }}";

            if (idTahun) {
                url += '?tahun_kurikulum=' + encodeURIComponent(idTahun);
            }

            window.location.href = url;
        }
    </script>
@endsection