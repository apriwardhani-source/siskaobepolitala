@extends('layouts.admin.app')

@section('content')
<div class="mx-20 mt-6">
    <h2 class="font-extrabold text-3xl mb-5 text-center">Edit Capaian Pembelajaran Lulusan</h2>
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

        <form action="{{ route('admin.capaianprofillulusan.update', $capaianprofillulusan->id_cpl) }}" method="POST">
            @csrf
            @method('PUT')

            <label for="kode_prodi" class="text-2xl font-semibold mb-2">Program Studi:</label>
            <select id="kode_prodi" name="kode_prodi"
                class="border border-black p-3 w-full rounded-lg mt-1 mb-3 focus:outline-none focus:ring-2 focus:ring-[#5460B5] focus:bg-[#f7faff]"
                required>
                <option value="" disabled>Pilih Program Studi</option>
                @foreach ($prodis as $prodi)
                    <option value="{{ $prodi->kode_prodi }}" 
                        {{ old('kode_prodi', $capaianprofillulusan->kode_prodi) == $prodi->kode_prodi ? 'selected' : '' }}>
                        {{ $prodi->nama_prodi }}
                    </option>
                @endforeach
            </select>

            <label for="id_tahun" class="text-2xl font-semibold mb-2">Tahun Kurikulum:</label>
            <select id="id_tahun" name="id_tahun"
                class="border border-black p-3 w-full rounded-lg mt-1 mb-3 focus:outline-none focus:ring-2 focus:ring-[#5460B5] focus:bg-[#f7faff]"
                required>
                <option value="" disabled>Pilih Tahun Kurikulum</option>
                @foreach ($tahuns as $tahun)
                    <option value="{{ $tahun->id_tahun }}" 
                        {{ old('id_tahun', $capaianprofillulusan->id_tahun) == $tahun->id_tahun ? 'selected' : '' }}>
                        {{ $tahun->tahun }}
                    </option>
                @endforeach
            </select>

            <label class="text-2xl" for="kode_cpl">Kode Capaian Profil Lulusan:</label>
            <input type="text" name="kode_cpl" id="kode_cpl" class="border border-black w-full rounded-lg p-3 mt-1 mb-3"
                value="{{ old('kode_cpl', $capaianprofillulusan->kode_cpl) }}" placeholder="Contoh: CPL-01" required>
            <br>

            <label class="text-2xl" for="deskripsi_cpl">Deskripsi Capaian Profil Lulusan:</label>
            <textarea name="deskripsi_cpl" id="deskripsi_cpl" class="border border-black w-full rounded-lg p-3 mb-3" rows="4"
                required>{{ old('deskripsi_cpl', $capaianprofillulusan->deskripsi_cpl) }}</textarea>
            <br>

            <label class="text-2xl" for="status_cpl">Status CPL:</label>
            <select name="status_cpl" id="status_cpl" class="border border-black p-3 mt-1 w-full rounded-lg mb-3" required>
                <option value="Kompetensi Utama Bidang"
                    {{ $capaianprofillulusan->status_cpl == 'Kompetensi Utama Bidang' ? 'selected' : '' }}>Kompetensi Utama Bidang</option>
                <option value="Kompetensi Tambahan"
                    {{ $capaianprofillulusan->status_cpl == 'Kompetensi Tambahan' ? 'selected' : '' }}>Kompetensi Tambahan</option>
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
