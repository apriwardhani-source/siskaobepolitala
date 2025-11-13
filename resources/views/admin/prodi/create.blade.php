@extends('layouts.admin.app')

@section('content')
    <div class="mx-20 mt-6">
        <h2 class="font-extrabold text-3xl mb-5 text-center">Tambah Prodi</h2>
        <hr class="border-t-2 md:border-t-4 border-black my-3 md:my-4 mx-auto">

        <div class="bg-white px-6 pb-6  rounded-lg shadow-md">

            @if ($errors->any())
                <div class="text-red-600 mb-4">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.prodi.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="max-w-2xl mx-auto space-y-4 pt-6">
                    <div>
                        <label for="kode_prodi" class="block text-lg font-semibold mb-2">Kode Prodi</label>
                        <input type="text" name="kode_prodi" id="kode_prodi" required
                            class="w-full p-3 border border-black rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:bg-[#fbfffd]">
                    </div>

                    <div>
                        <label for="nama_prodi" class="block text-lg font-semibold mb-2">Nama Prodi</label>
                        <input type="text" name="nama_prodi" id="nama_prodi" required
                            class="w-full p-3 border border-black rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:bg-[#fbfffd]">
                    </div>

                    <div>
                        <label for="nama_kaprodi" class="block text-lg font-semibold mb-2">Nama Kaprodi</label>
                        <input type="text" name="nama_kaprodi" id="nama_kaprodi" required
                            class="w-full p-3 border border-black rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:bg-[#fbfffd]">
                    </div>

                    <div>
                        <label for="jenjang_pendidikan" class="block text-lg font-semibold mb-2">Jenjang Pendidikan</label>
                        <select name="jenjang_pendidikan" id="jenjang_pendidikan" required
                            class="w-full p-3 border border-black rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:bg-[#fbfffd]">
                            <option value="" disabled selected>Pilih Jenjang</option>
                            <option value="D3">D3</option>
                            <option value="D4">D4</option>
                        </select>
                    </div>
                </div>

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
