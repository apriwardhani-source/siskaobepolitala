@extends('layouts.app')

@section('content')

<div class="mx-20 mt-6">
    <h2 class="font-extrabold text-3xl mb-5 text-center">Tambah Capaian Pembelajaran Lulusan</h2>
    <hr class="border-t-2 md:border-t-4 border-black my-3 md:my-4 mx-auto">

        @if ($errors->any())
            <div style="color: red;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.capaianprofillulusan.store') }}" method="POST">
            @csrf

            <label for="kode_prodi" class="text-xl font-semibold mb-2">Program Studi</label>
            <select id="kode_prodi" name="kode_prodi"
                class="border border-black p-3 w-full rounded-lg mt-1 mb-3 focus:outline-none focus:ring-2 focus:ring-[#5460B5] focus:bg-[#f7faff]"
                required>
                <option value="" disabled selected>Pilih Program Studi</option>
                @foreach ($prodis as $prodi)
                    <option value="{{ $prodi->kode_prodi }}">{{ $prodi->nama_prodi }}</option>
                @endforeach
            </select>

            <label for="id_tahun" class="text-xl font-semibold mb-2">Tahun Kurikulum</label>
            <select id="id_tahun" name="id_tahun"
                class="border border-black p-3 w-full rounded-lg mt-1 mb-3 focus:outline-none focus:ring-2 focus:ring-[#5460B5] focus:bg-[#f7faff]"
                required>
                <option value="" disabled selected>Pilih Tahun Kurikulum</option>
                @foreach ($tahuns as $tahun)
                    <option value="{{ $tahun->id_tahun }}">{{ $tahun->tahun }}</option>
                @endforeach
            </select>

            <label for="kode_cpl" class="text-xl font-semibold">Kode CPL</label>
            <input type="text" id="kode_cpl" name="kode_cpl" class="border border-black p-3 w-full rounded-lg mt-1 mb-3"
                placeholder="Contoh: CPL-01" required>
            <br>

            <label for="deskripsi_cpl" class="text-xl font-semibold">Deskripsi CPL</label>
            <textarea id="deskripsi_cpl" name="deskripsi_cpl"
                class="border border-black p-3 w-full rounded-lg mt-1 mb-3" rows="4" required></textarea>
            <br>

            <label for="status_cpl" class="text-xl font-semibold">Status CPL</label>
            <select id="status_cpl" name="status_cpl" class="border border-black p-3 w-full rounded-lg mt-1 mb-3" required>
                <option value="" selected disabled>Pilih Status CPL</option>
                <option value="Kompetensi Utama Bidang">Kompetensi Utama Bidang</option>
                <option value="Kompetensi Tambahan">Kompetensi Tambahan</option>
            </select>
            <br>
            
                <div class="flex justify-end space-x-5 mt-[50px]">
                    <a href="{{ route('admin.capaianprofillulusan.index') }}" 
                       class="px-6 py-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg transition duration-200">
                        Kembali
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition duration-200">
                        Simpan
                    </button>
                </div>
        </form>
    </div>
@endsection
