@extends('layouts.app')

@section('title', 'Edit Prodi')

@section('content')
    <div class="mx-20 mt-6">
        <h2 class="text-3xl font-extrabold mb-5 text-center">Edit Prodi</h2>
        <hr class="border-t-2 md:border-t-4 border-black my-3 md:my-4 mx-auto">

        <div class="bg-white px-6 pb-6 rounded-lg shadow-md">
            @if ($errors->any())
                <div class="text-red-600 mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.prodi.update', $prodi->kode_prodi) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="max-w-2xl mx-auto space-y-4 pt-6">
                    <div>
                        <label for="kode_prodi" class="block text-lg font-semibold mb-2">Kode Prodi</label>
                        <input type="text" name="kode_prodi" id="kode_prodi" value="{{ old('kode_prodi', $prodi->kode_prodi) }}"
                            class="w-full p-3 border border-black rounded-lg" required>
                    </div>

                    <div>
                        <label for="nama_prodi" class="block text-lg font-semibold mb-2">Nama Prodi</label>
                        <input type="text" name="nama_prodi" id="nama_prodi" value="{{ old('nama_prodi', $prodi->nama_prodi) }}"
                            class="w-full p-3 border border-black rounded-lg" required>
                    </div>

                    <div>
                        <label for="nama_kaprodi" class="block text-lg font-semibold mb-2">Nama Kaprodi</label>
                        <input type="text" name="nama_kaprodi" id="nama_kaprodi"
                            value="{{ old('nama_kaprodi', $prodi->nama_kaprodi) }}"
                            class="w-full p-3 border border-black rounded-lg" required>
                    </div>

                    <div>
                        <label for="jenjang_pendidikan" class="block text-lg font-semibold mb-2">Jenjang Pendidikan</label>
                        <select name="jenjang_pendidikan" id="jenjang_pendidikan" class="w-full p-3 border border-black rounded-lg" required>
                            <option value="D3" {{ $prodi->jenjang_pendidikan == 'D3' ? 'selected' : '' }}>D3</option>
                            <option value="D4" {{ $prodi->jenjang_pendidikan == 'D4' ? 'selected' : '' }}>D4</option>
                        </select>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex justify-end space-x-5 pt-6">
                    <a href="{{ route('admin.prodi.index') }}"
                        class="px-6 py-2 bg-blue-600 hover:bg-blue-900 text-white font-semibold rounded-lg transition duration-200">
                        Kembali
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-green-600 hover:bg-green-800 text-white font-semibold rounded-lg transition duration-200">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
