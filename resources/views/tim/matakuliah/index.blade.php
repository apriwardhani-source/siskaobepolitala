@extends('layouts.tim.app')

@section('content')
    <div class="bg-white p-4 md:p-6 lg:p-8 rounded-lg shadow-md mx-2 md:mx-0">

        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Daftar Mata Kuliah</h1>
            <hr class="border-t-2 md:border-t-4 border-black my-3 md:my-4 mx-auto">
        </div>

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

        @if (session('error'))
            <div id="alertError" class="bg-red-500 text-white px-4 py-2 rounded-md mb-4 text-center relative">
                <span class="font-bold">{{ session('error') }}</span>
                <button onclick="document.getElementById('alertError').style.display='none'"
                    class="absolute top-1 right-3 text-white font-bold text-lg">
                    &times;
                </button>
            </div>
        @endif

        <div class="flex justify-between mb-4">
            <div class="space-x-2">
                <a href="{{ route('tim.matakuliah.download-template') }}"
                    class="bg-green-600 inline-flex text-white font-bold px-4 py-2 rounded-md hover:bg-green-800">
                    <i class="bi bi-download mr-2"></i> Template
                </a>
                <button onclick="document.getElementById('importModal').classList.remove('hidden')"
                    class="bg-purple-600 inline-flex text-white font-bold px-4 py-2 rounded-md hover:bg-purple-800">
                    <i class="bi bi-file-earmark-arrow-up mr-2"></i> Import
                </button>
                <a href="{{ route('tim.matakuliah.create') }}"
                    class="bg-blue-600 inline-flex text-white font-bold px-4 py-2 rounded-md hover:bg-blue-800">
                    <i class="bi bi-plus-circle mr-2"></i> Tambah
                </a>
            </div>
            <select id="tahun" name="id_tahun"
                class="border border-black ml-4 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
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
                    <a href="{{ route('tim.matakuliah.index') }}"
                        class="text-xs text-blue-600 hover:text-blue-800 underline">
                        Reset filter
                    </a>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow overflow-hidden">
            @if ($mata_kuliahs->isEmpty())
                <div class="p-8 text-center text-gray-600">
                    Data belum dibuat untuk prodi ini.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-300 shadow-md">
                    <thead class="bg-green-800 text-white border-b">
                        <tr>
                            <th class="py-2 px-3 text-center w-16 font-bold uppercase">No</th>
                            <th class="py-2 px-3 text-center font-bold uppercase whitespace-nowrap">Kode MK</th>
                            <th class="py-2 px-3 text-center font-bold uppercase min-w-[200px]">Nama MK</th>
                            <th class="py-2 px-3 text-center font-bold uppercase whitespace-nowrap">SKS</th>
                            @for ($i = 1; $i <= 8; $i++)
                                <th class="py-2 px-3 text-center whitespace-nowrap">Smt {{ $i }}</th>
                            @endfor
                            <th class="py-2 px-3 text-center font-bold uppercase whitespace-nowrap">Kompetensi</th>
                            <th class="py-2 px-3 text-center font-bold uppercase whitespace-nowrap min-w-[150px] sticky right-0 bg-green-800">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mata_kuliahs as $index => $mata_kuliah)
                            <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : 'bg-white' }} hover:bg-gray-200 border-b">
                                <td class="py-2 px-3 text-center whitespace-nowrap">{{ $index + 1 }}</td>
                                <td class="py-2 px-3 text-center whitespace-nowrap">{{ $mata_kuliah->kode_mk }}</td>
                                <td class="py-2 px-3">{{ $mata_kuliah->nama_mk }}</td>
                                <td class="py-2 px-3 text-center whitespace-nowrap">{{ $mata_kuliah->sks_mk }}</td>
                                @for ($i = 1; $i <= 8; $i++)
                                    <td class="py-2 px-3 items-center text-center whitespace-nowrap">
                                        @if ($mata_kuliah->semester_mk == $i)
                                            ✔️
                                        @endif
                                    </td>
                                @endfor
                                <td class="py-2 px-3 text-center whitespace-nowrap">{{ $mata_kuliah->kompetensi_mk }}</td>
                                <td class="py-2 px-3 sticky right-0 {{ $index % 2 == 0 ? 'bg-gray-100' : 'bg-white' }}">
                                    <div class="flex justify-center items-center space-x-2">
                                    <a href="{{ route('tim.matakuliah.detail', $mata_kuliah->kode_mk) }}"
                                        class="bg-gray-600 hover:bg-gray-700 text-white p-2 rounded-md inline-flex items-center justify-center"
                                        title="Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M18 10A8 8 0 11 2 10a8 8 0 0116 0zm-9-3a1 1 0 112 0 1 1 0 01-2 0zm2 5a1 1 0 10-2 0v2a1 1 0 102 0v-2z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('tim.matakuliah.edit', $mata_kuliah->kode_mk) }}"
                                        class="bg-blue-600 hover:bg-blue-800 text-white p-2 rounded-md" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path
                                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('tim.matakuliah.destroy', $mata_kuliah->kode_mk) }}"
                                        method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="bg-red-600 hover:bg-red-800 text-white p-2 rounded-md"
                                            title="Hapus" onclick="return confirm('Hapus mata kuliah ini?')">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                fill="currentColor">
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

            let url = "{{ route('tim.matakuliah.index') }}";

            if (idTahun) {
                url += '?id_tahun=' + encodeURIComponent(idTahun);
            }

            window.location.href = url;
        }
    </script>

    <!-- Import Modal -->
    <div id="importModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold">Import Mata Kuliah</h3>
                <button onclick="document.getElementById('importModal').classList.add('hidden')"
                    class="text-gray-500 hover:text-gray-700">
                    <i class="bi bi-x-lg text-2xl"></i>
                </button>
            </div>
            
            <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded">
                <p class="text-sm text-blue-800">
                    <strong>Format file:</strong> Excel (.xlsx, .xls) atau CSV<br>
                    <strong>Kolom:</strong> kode_mk, nama_mk, sks_mk, semester_mk, kompetensi_mk, jenis_mk, kode_cpl<br>
                    <strong>Kode CPL:</strong> Pisahkan dengan koma jika lebih dari 1 (contoh: CPL01,CPL02)
                </p>
            </div>

            <form action="{{ route('tim.matakuliah.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Pilih File Excel:</label>
                    <input type="file" name="file" accept=".xlsx,.xls,.csv" required
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" 
                        onclick="document.getElementById('importModal').classList.add('hidden')"
                        class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-800">
                        Upload & Import
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
