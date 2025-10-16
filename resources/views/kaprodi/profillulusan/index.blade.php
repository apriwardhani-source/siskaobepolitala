@extends('layouts.kaprodi.app')

@section('content')
    <div class="bg-white p-4 md:p-6 lg:p-8 rounded-lg shadow-md mx-2 md:mx-0">
        <h2 class="text-2xl font-bold mb-4 text-center">Daftar Profil Lulusan</h2>
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
                    <a href="{{ route('kaprodi.profillulusan.index') }}"
                        class="text-xs text-blue-600 hover:text-blue-800 underline">
                        Reset filter
                    </a>
                </div>
            </div>
        @endif
        <div class="w-full overflow-x-auto shadow-lg rounded-lg border border-gray-300">
            <table class="min-w-full table-fixed">
                <thead class="bg-green-800 text-white">
                    <tr class="text-center">
                        <th class="py-3 px-4 w-10 text-center border border-gray-300">No.</th>
                        <th class="px-4 py-2 text-center w-16 border border-gray-300">Kode PL</th>
                        <th class="px-4 py-2 text-center w-64 border border-gray-300">Deskripsi</th>
                        <th class="px-4 py-2 text-center min-w-[200px] border border-gray-300">Profesi</th>
                        <th class="px-4 py-2 text-center w-32 border border-gray-300">Unsur</th>
                        <th class="px-4 py-2 text-center w-28 border border-gray-300">Keterangan</th>
                        <th class="px-4 py-2 text-center w-40 border border-gray-300">Sumber</th>
                        <th class="px-4 py-2 text-center w-32 border border-gray-300">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($profillulusans as $index => $profillulusan)
                        <tr class="align-top {{ $index % 2 == 0 ? 'bg-gray-100' : 'bg-white' }} hover:bg-gray-200 border-b">
                            <td class="px-4 py-2 w-10 text-center border border-gray-300">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 w-16 text-center border border-gray-300">
                                {{ $profillulusan->kode_pl }}</td>
                            <td class="px-4 py-2 w-64 whitespace-normal text-justify border border-gray-300">
                                {{ $profillulusan->deskripsi_pl }}
                            </td>
                            <td class="px-4 py-2 min-w-[200px] whitespace-normal border border-gray-300">
                                {{ $profillulusan->profesi_pl }}
                            </td>
                            <td class="px-4 py-2 w-32 text-justify border border-gray-300">
                                {{ $profillulusan->unsur_pl }}</td>
                            <td class="px-4 py-2 w-28 text-center border border-gray-300">
                                {{ $profillulusan->keterangan_pl }}</td>
                            <td class="px-4 py-2 w-40 text-justify border border-gray-300">
                                {{ $profillulusan->sumber_pl }}</td>
                            <td class="px-4 py-4 w-32 border border-gray-300">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('kaprodi.profillulusan.detail', $profillulusan->id_pl) }}"
                                        class="bg-gray-600 hover:bg-gray-700 text-white p-2 rounded-md inline-flex items-center justify-center"
                                        title="Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M18 10A8 8 0 11 2 10a8 8 0 0116 0zm-9-3a1 1 0 112 0 1 1 0 01-2 0zm2 5a1 1 0 10-2 0v2a1 1 0 102 0v-2z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                    {{-- <a href="{{ route('kaprodi.profillulusan.edit', $profillulusan->id_pl) }}"
                                                class="bg-blue-600 hover:bg-blue-800 text-white p-2 rounded-md inline-flex items-center justify-center"
                                                title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path
                                                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                </svg>
                                            </a>
                                            <form
                                                action="{{ route('kaprodi.profillulusan.destroy', $profillulusan->id_pl) }}"
                                                method="POST">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-600 hover:bg-red-800 text-white p-2 rounded-md inline-flex items-center justify-center"
                                                    title="Hapus" onclick="return confirm('Hapus data ini?')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </form> --}}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        function updateFilter() {
            const tahunSelect = document.getElementById('tahun');
            const idTahun = tahunSelect.value;

            let url = "{{ route('kaprodi.profillulusan.index') }}";

            if (idTahun) {
                url += '?id_tahun=' + encodeURIComponent(idTahun);
            }

            window.location.href = url;
        }
    </script>
@endsection
