@extends('layouts.tim.app')
@section('content')

    <div class="ml-20 mr-20">
        <h1 class="text-4xl text-center font-extrabold mb-4">Edit Mata Kuliah</h1>
        <hr class="border border-black mb-3">
        @if ($errors->any())
            <div style="color: red;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('tim.matakuliah.update', $matakuliah->kode_mk) }}" method="POST">
            @csrf
            @method('PUT')

            <label class="text-xl font-semibold mb-2">CPL Terkait:</label>
            <div class="border border-black p-4 w-full rounded-lg mt-1 mb-3 max-h-60 overflow-y-auto">
                @foreach ($capaianprofillulusans as $cpl)
                    <div class="mb-2">
                        <label class="flex items-start">
                            <input type="checkbox" name="id_cpls[]" value="{{ $cpl->id_cpl }}" 
                                {{ in_array($cpl->id_cpl, $selectedCplIds ?? []) ? 'checked' : '' }}
                                class="mt-1 mr-2" required>
                            <span class="text-sm">{{ $cpl->kode_cpl }} - {{ $cpl->deskripsi_cpl }}</span>
                        </label>
                    </div>
                @endforeach
            </div>
            <p class="italic text-red-700 mb-3">*Pilih minimal satu CPL.</p>

            <label for="kode_mk" class="text-xl font-semibold">Kode MK</label>
            <input type="text" name="kode_mk" id="kode_mk" value="{{ old('kode_mk', $matakuliah->kode_mk) }}"
                class="border border-black p-3 w-full mt-1 mb-3 rounded-lg" required>
            <br>
            <label for="nama_mk" class="text-xl font-semibold">Nama MK</label>
            <input type="text" name="nama_mk" id="nama_mk" value="{{ old('nama_mk', $matakuliah->nama_mk) }}"
                class="border border-black p-3 w-full mt-1 mb-3 rounded-lg" required>
            <br>
            <label for="sks_mk" class="text-xl font-semibold">Sks MK</label>
            <input type="number" name="sks_mk" id="sks_mk" value="{{ old('sks_mk', $matakuliah->sks_mk) }}"
                class="border border-black p-3 w-full mt-1 mb-3 rounded-lg" required>
            <br>
            <label for="semester_mk" class="text-xl font-semibold">Semester</label>
            <select name="semester_mk" id="semester_mk" class="border border-black p-3 w-full mt-1 mb-3 rounded-lg"
                required>
                @for ($i = 1; $i <= 8; $i++)
                    <option value="{{ $i }}" {{ $matakuliah->semester_mk == $i ? 'selected' : '' }}>
                        {{ $i }}
                    </option>
                @endfor
            </select>
            <br>
            <label for="kompetensi_mk" class="text-xl font-semibold">Kompetensi MK</label>
            <select name="kompetensi_mk" id="kompetensi_mk" class="border border-black p-3 w-full mt-1 mb-3 rounded-lg"
                required>
                <option value="pendukung" {{ $matakuliah->kompetensi_mk == 'pendukung' ? 'selected' : '' }}>pendukung
                </option>
                <option value="utama" {{ $matakuliah->kompetensi_mk == 'utama' ? 'selected' : '' }}>utama</option>
            </select>

            <button type="submit"
                class="mt-3 bg-blue-600 hover:bg-blue-800 px-5 py-2 rounded-lg text-white font-semibold">Simpan</button>
            <a href="{{ route('tim.matakuliah.index') }}"
                class="ml-2 bg-gray-600 hover:bg-gray-800 px-5 py-2 rounded-lg text-white font-semibold">Kembali</a>
        </form>
    </div>

@endsection
