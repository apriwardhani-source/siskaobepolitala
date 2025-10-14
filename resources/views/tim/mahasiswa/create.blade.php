@extends('layouts.tim.app')

@section('content')
    <div class="mr-20 ml-20">
        <h2 class="text-4xl font-extrabold text-center mb-4">Tambah Mahasiswa</h2>
        <hr class="w-full border border-black mb-4">

        @if ($errors->any())
            <div style="color: red; margin-bottom: 10px;">
                <ul style="list-style-type: none; padding: 0;">
                    @foreach ($errors->all() as $error)
                        <li style="margin: 5px 0;">&bull; {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('tim.mahasiswa.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kolom Pertama -->
                <div class="space-y-4">
                    <div>
                        <label for="nim" class="block text-lg font-semibold mb-2 text-gray-700">NIM</label>
                        <input type="text" id="nim" name="nim" value="{{ old('nim') }}" required
                            class="w-full p-3 border border-black rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:bg-[#fbfffd]">
                    </div>

                    <div>
                        <label for="nama_mahasiswa" class="block text-lg font-semibold mb-2 text-gray-700">Nama Mahasiswa</label>
                        <input type="text" id="nama_mahasiswa" name="nama_mahasiswa" value="{{ old('nama_mahasiswa') }}" required
                            class="w-full p-3 border border-black rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:bg-[#fbfffd]">
                    </div>

                    <div>
                        <label for="id_tahun_kurikulum" class="block text-lg font-semibold mb-2 text-gray-700">Tahun Kurikulum</label>
                        <select id="id_tahun_kurikulum" name="id_tahun_kurikulum" required
                            class="w-full p-3 border border-black rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:bg-[#fbfffd]">
                            <option value="" selected disabled>Pilih Tahun Kurikulum</option>
                            @foreach ($tahun_angkatans as $tahun)
                                <option value="{{ $tahun->id_tahun }}" {{ old('id_tahun_kurikulum') == $tahun->id_tahun ? 'selected' : '' }}>
                                    {{ $tahun->tahun }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Kolom Kedua -->
                <div class="space-y-4">
                    <div>
                        <label for="kode_prodi" class="block text-lg font-semibold mb-2 text-gray-700">Program Studi</label>
                        <input type="text" class="w-full p-3 border border-black rounded-lg bg-gray-100"
                            value="{{ $prodis->first()->nama_prodi }}" readonly>
                        <input type="hidden" name="kode_prodi" value="{{ $prodis->first()->kode_prodi }}">
                    </div>

                    <div>
                        <label for="status" class="block text-lg font-semibold mb-2 text-gray-700">Status</label>
                        <select id="status" name="status"
                            class="w-full p-3 border border-black rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:bg-[#fbfffd]">
                            <option value="aktif" {{ old('status', 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="lulus" {{ old('status') == 'lulus' ? 'selected' : '' }}>Lulus</option>
                            <option value="cuti" {{ old('status') == 'cuti' ? 'selected' : '' }}>Cuti</option>
                            <option value="keluar" {{ old('status') == 'keluar' ? 'selected' : '' }}>Keluar</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex space-x-4">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-800 px-6 py-2 rounded-lg text-white font-bold">Simpan</button>
                <a href="{{ route('tim.mahasiswa.index') }}"
                    class="bg-gray-600 hover:bg-gray-700 px-6 py-2 rounded-lg text-white font-bold">Kembali</a>
            </div>
        </form>
    </div>
@endsection