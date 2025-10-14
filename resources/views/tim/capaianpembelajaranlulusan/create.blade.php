@extends('layouts.tim.app')

@section('content')

    <div class="mr-20 ml-20">

        <h2 class="text-4xl font-extrabold mb-4 text-center">Tambah Capaian Profil Lulusan</h2>
        <hr class="w-full border border-black mb-4">

        @if ($errors->any())
            <div style="color: red;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('tim.capaianpembelajaranlulusan.store') }}" method="POST">
            @csrf

            <label for="id_tahun" class="text-xl font-semibold mb-2">Tahun Kurikulum (Opsional):</label>
            <select id="id_tahun" name="id_tahun"
                class="border border-black p-3 w-full rounded-lg mt-1 mb-3 focus:outline-none focus:ring-2 focus:ring-[#5460B5] focus:bg-[#f7faff]">
                <option value="">Pilih Tahun (Kosongkan jika tidak ada)</option>
                @foreach ($tahun_tersedia as $tahun)
                    <option value="{{ $tahun->id_tahun }}">{{ $tahun->tahun }}</option>
                @endforeach
            </select>

            <label for="kode_cpl" class="text-xl font-semibold">Kode CPL:</label>
            <input type="text" id="kode_cpl" name="kode_cpl" class="border border-black p-3 w-full rounded-lg mt-1 mb-3"
                required></input>
            <br>

            <label for="deskripsi_cpl" class="text-xl font-semibold">Deskripsi CPL:</label>
            <textarea id="deskripsi_cpl" type="text" name="deskripsi_cpl"
                class="border border-black p-3 w-full rounded-lg mt-1 mb-3" required></textarea>
            <br>

            <label for="status_cpl" class="text-xl font-semibold">Status CPL:</label>
            <select id="status_cpl" name="status_cpl" class="border border-black p-3 w-full rounded-lg mt-1 mb-5" required>
                <option value="" selected disabled>Pilih Status CPL</option>
                <option value="Kompetensi Utama Bidang">Kompetensi Utama Bidang</option>
                <option value="Kompetensi Tambahan">Kompetensi Tambahan</option>
            </select>
            <br>

            <button type="submit"
                class="bg-blue-600 hover:bg-blue-800 mt-2 rounded-lg px-5 py-2 text-white font-bold">Simpan</button>
            <a href="{{ route('tim.capaianpembelajaranlulusan.index') }}"
                class="ml-2 bg-gray-600 hover:bg-gray-700 px-5 py-2 rounded-lg text-white font-bold">Kembali</a>
        </form>
    </div>
@endsection
