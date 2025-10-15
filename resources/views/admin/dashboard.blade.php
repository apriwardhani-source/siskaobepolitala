@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <div class="bg-white p-4 md:p-6 lg:p-8 rounded-lg shadow-md mx-2 md:mx-0">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Dashboard Penyusunan Kurikulum OBE</h1>
            <p class="text-gray-600 mt-2">Progress implementasi kurikulum berbasis Outcome-Based Education per Program Studi
            </p>
            <hr class="border-t-4 border-black my-5">
        </div>

        <!-- Filter dan Pencarian -->
        <div class="mb-10 flex flex-col sm:flex-row sm:items-center flex-wrap gap-4 justify-between">
            <div class="flex flex-col sm:flex-row flex-wrap gap-2 sm:gap-5 items-stretch">
                @if (Auth::user()->role === 'admin' && isset($prodis))
                    <form id="exportForm" action="{{ route('admin.export.excel') }}" method="GET"
                        class="flex flex-col sm:flex-row flex-wrap gap-2 sm:gap-4 items-stretch">
                        <!-- Select Prodi -->
                        <select name="kode_prodi" id="prodiSelect" required
                            class="min-w-[150px] text-center flex-1 border border-black px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="" selected disabled>Pilih Prodi</option>
                            @foreach ($prodis as $prodi)
                                <option value="{{ $prodi->kode_prodi }}">{{ $prodi->nama_prodi }}</option>
                            @endforeach
                        </select>

                        <!-- Select Tahun -->
                        <select name="id_tahun" id="tahunSelect" required
                            class="min-w-[150px] text-center flex-1 border border-black px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="" disabled {{ empty($id_tahun) ? 'selected' : '' }}>Pilih Tahun</option>
                            @foreach ($availableYears as $th)
                                <option value="{{ $th->id_tahun }}" {{ $id_tahun == $th->id_tahun ? 'selected' : '' }}>
                                    {{ $th->tahun }}
                                </option>
                            @endforeach
                        </select>

                        <!-- Tombol Export -->
                        <button type="submit"
                            class="bg-green-600 text-white px-4 sm:px-5 font-bold py-2 rounded-md hover:bg-green-800 whitespace-nowrap">
                            <i class="fas fa-file-excel mr-2"></i>Excel
                        </button>

                        <button type="button" onclick="exportWord()"
                            class="bg-blue-600 px-4 py-2 rounded-lg text-white hover:bg-blue-800">
                            <i class="fas fa-file-word mr-2"></i>Word
                        </button>

                    </form>
                @else
                    <form action="{{ route('tim.export.excel') }}" method="GET"
                        class="flex flex-col sm:flex-row flex-wrap gap-2 sm:gap-4 items-stretch">
                        <select name="id_tahun" id="tahunSelect" required
                            class="min-w-0 flex-1 border border-black px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="" disabled {{ empty($id_tahun) ? 'selected' : '' }}>Pilih Tahun</option>
                            @foreach ($availableYears as $th)
                                <option value="{{ $th->id_tahun }}" {{ $id_tahun == $th->id_tahun ? 'selected' : '' }}>
                                    {{ $th->tahun }}
                                </option>
                            @endforeach
                        </select>

                        <button type="submit"
                            class="bg-green-600 text-white px-4 sm:px-5 font-bold py-2 rounded-md hover:bg-green-800 whitespace-nowrap">
                            <i class="fas fa-file-excel mr-2"></i>Excel
                        </button>
                    </form>
                @endif
            </div>

            <!-- Search -->
            <div class="sm:min-w-[250px] w-full sm:w-auto">
                <div
                    class="flex items-center border border-black rounded-md focus-within:ring-2 focus-within:ring-green-500 bg-white">
                    <span class="pl-3 text-gray-400">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" id="search-prodi-dashboard" placeholder="Search..."
                        class="px-3 py-2 w-full focus:outline-none bg-transparent" />
                </div>
            </div>

        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-lg shadow p-5 border-l-4 border-blue-500">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Program Studi</p>
                        <h2 class="text-2xl font-bold text-gray-800">{{ $prodicount }}</h2>
                    </div>
                    <div class="bg-blue-100 p-2 rounded-full">
                        <i class="fas fa-graduation-cap text-blue-500"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-5 border-l-4 border-green-500">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Sudah Selesai</p>
                        <h2 class="text-2xl font-bold text-gray-800">{{ $ProdiSelesai }}</h2>
                    </div>
                    <div class="bg-green-100 p-2 rounded-full">
                        <i class="fas fa-check-circle text-green-500"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-5 border-l-4 border-yellow-500">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Proses Implementasi</p>
                        <h2 class="text-2xl font-bold text-gray-800">{{ $ProdiProgress }}</h2>
                    </div>
                    <div class="bg-yellow-100 p-2 rounded-full">
                        <i class="fas fa-cog text-yellow-500"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-5 border-l-4 border-red-500">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Belum Dimulai</p>
                        <h2 class="text-2xl font-bold text-gray-800">{{ $ProdiBelumMulai }}</h2>
                    </div>
                    <div class="bg-red-100 p-2 rounded-full">
                        <i class="fas fa-exclamation-circle text-red-500"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Tahun untuk Progress -->
        <form method="GET" action="{{ route('admin.dashboard') }}" class="flex items-center">
            <label for="tahun_progress" class="mr-2 text-gray-600 text-sm">Tahun Progress:</label>
            <select name="tahun_progress" id="tahun_progress"
                class="border border-black px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                required onchange="this.form.submit()">
                <option value="" disabled selected>Pilih Tahun</option>
                @foreach ($availableYears as $th)
                    <option value="{{ $th->id_tahun }}"
                        {{ request('tahun_progress') == $th->id_tahun ? 'selected' : '' }}>
                        {{ $th->tahun }}
                    </option>
                @endforeach
            </select>
        </form>

        <!-- Progress Bar Per Prodi -->
        @if (request()->filled('tahun_progress'))
            <div class="bg-white rounded-lg shadow-lg p-2 mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Progress Penyusunan Kurikulum OBE</h2>

                <div class="space-y-6">
                    {{-- Penjelasan target kurikulum OBE --}}
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
                        <h4 class="font-semibold text-blue-800 mb-2">Target Standar Kurikulum OBE:</h4>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm text-blue-700">
                            <div>
                                <strong>CPL:</strong> 9
                                <p class="text-xs text-blue-600">Capaian Profil Lulusan</p>
                            </div>
                            <div>
                                <strong>Total SKS:</strong> 144
                                <p class="text-xs text-blue-600">Mata Kuliah (program D4)</p>
                            </div>
                            <div>
                                <strong>CPMK:</strong> 20
                                <p class="text-xs text-blue-600">Capaian Pembelajaran MK</p>
                            </div>
                            <div>
                                <strong>Sub CPMK:</strong> 40
                                <p class="text-xs text-blue-600">Indikator pencapaian</p>
                            </div>
                        </div>
                    </div>
                    @foreach ($prodis as $prodi)
                        <div class="border-b pb-5 prodi-card">
                            <div class="flex justify-between items-center mb-2">
                                <h3 class="font-semibold text-gray-800">{{ $prodi->nama_prodi }}</h3>
                                <div class="bg-green-100 text-green-700 text-sm font-medium px-3 py-1 rounded-full">
                                    {{ $prodi->avg_progress }}% Selesai
                                </div>
                            </div>

                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-green-500 h-2.5 rounded-full" style="width: {{ $prodi->avg_progress }}%">
                                </div>
                            </div>

                            <div class="flex justify-between mt-3 text-xs text-gray-600">
                                <div class="flex flex-wrap gap-x-6 gap-y-2">
                                    <span class="flex items-center">
                                        <span class="w-3 h-3 bg-blue-500 rounded-full mr-1"></span>
                                        <strong>CPL:</strong> {{ $prodi->cpl_count }}/9 ({{ $prodi->progress_cpl }}%)
                                    </span>
                                    <span class="flex items-center">
                                        <span class="w-3 h-3 bg-yellow-500 rounded-full mr-1"></span>
                                        <strong>SKS:</strong> {{ $prodi->sks_mk }}/144 ({{ $prodi->progress_sks_mk }}%)
                                    </span>
                                    <span class="flex items-center">
                                        <span class="w-3 h-3 bg-orange-500 rounded-full mr-1"></span>
                                        <strong>CPMK:</strong> {{ $prodi->cpmk_count }}/20 ({{ $prodi->progress_cpmk }}%)
                                    </span>
                                    <span class="flex items-center">
                                        <span class="w-3 h-3 bg-red-500 rounded-full mr-1"></span>
                                        <strong>Sub CPMK:</strong> {{ $prodi->subcpmk_count }}/40 ({{ $prodi->progress_subcpmk }}%)
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="bg-white p-8 text-center text-gray-600 rounded-lg shadow mb-8">
                <strong>Silakan pilih tahun progress terlebih dahulu untuk menampilkan data.</strong>
            </div>
        @endif

    </div>
    
    <script>
        function exportWord(e) {
            event.preventDefault(); // ⬅️ cegah link langsung reload

            const form = document.getElementById('exportForm');
            const prodi = form.querySelector('select[name="kode_prodi"]').value;
            const tahun = form.querySelector('select[name="id_tahun"]').value;

            if (!prodi || !tahun) {
                alert('Harap pilih Prodi dan Tahun terlebih dahulu.');
                return;
            }

            const url = `{{ url('/export/kpt') }}?kode_prodi=${prodi}&id_tahun=${tahun}`;
            window.open(url, '_blank');
        }
    </script>

@endsection
