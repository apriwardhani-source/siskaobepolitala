@extends('layouts.admin.app')
@section('content')

    <div class="container mx-auto px-10">
        <h2 class="font-extrabold text-4xl mb-6 text-center">Tambah MataKuliah</h2>
        <hr class="w-full border border-black mb-8">

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.matakuliah.store') }}" method="POST">
            @csrf
            
            <div class="mb-6">
                <label class="text-xl font-semibold mb-2 block">CPL Terkait:</label>
                <div class="border border-black p-4 rounded-lg max-h-64 overflow-y-auto bg-gray-50">
                    @forelse ($capaianProfilLulusans as $cpl)
                        <label class="flex items-start mb-3 p-2 hover:bg-blue-50 rounded cursor-pointer">
                            <input type="checkbox" name="id_cpls[]" value="{{ $cpl->id_cpl }}" 
                                class="mr-3 mt-1 h-4 w-4 text-blue-600 rounded">
                            <span class="text-sm">
                                <strong>{{ $cpl->kode_cpl }}</strong> - {{ $cpl->deskripsi_cpl }}
                            </span>
                        </label>
                    @empty
                        <p class="text-gray-500 italic">Belum ada CPL tersedia</p>
                    @endforelse
                </div>
                <p class="italic text-red-700 text-sm mt-2">*Pilih minimal 1 CPL</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="space-y-6">
                    <div>
                        <label for="kode_mk" class="block text-xl font-medium">Kode Mata Kuliah</label>
                        <input type="text" name="kode_mk" id="kode_mk"
                            class="mt-1 w-full p-3 border border-black rounded-lg focus:ring-[#5460B5] focus:border-[#5460B5]">
                    </div>

                    <div>
                        <label for="nama_mk" class="block text-xl font-medium">Nama Mata Kuliah</label>
                        <input type="text" name="nama_mk" id="nama_mk"
                            class="mt-1 w-full p-3 border border-black rounded-lg focus:ring-[#5460B5] focus:border-[#5460B5]">
                    </div>

                    <div>
                        <label for="jenis_mk" class="block text-xl font-medium">Jenis MataKuliah</label>
                        <input type="text" name="jenis_mk" id="jenis_mk"
                            class="mt-1 w-full p-3 border border-black rounded-lg focus:ring-[#5460B5] focus:border-[#5460B5]">
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label for="sks_mk" class="block text-xl font-medium">SKS MataKuliah</label>
                        <input type="number" name="sks_mk" id="sks_mk"
                            class="mt-1 w-full p-3 border border-black rounded-lg focus:ring-[#5460B5] focus:border-[#5460B5]">
                    </div>

                    <div>
                        <label for="semester_mk" class="block text-xl font-medium">Semester MataKuliah</label>
                        <select name="semester_mk" id="semester_mk"
                            class="mt-1 w-full p-3 border border-black rounded-lg focus:ring-[#5460B5] focus:border-[#5460B5]">
                            <option value="" disabled selected>Pilih Semester</option>
                            @for ($i = 1; $i <= 8; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <div>
                        <label for="kompetensi_mk" class="block text-xl font-medium">Kompetensi MataKuliah</label>
                        <select name="kompetensi_mk" id="kompetensi_mk"
                            class="mt-1 w-full p-3 border border-black rounded-lg focus:ring-[#5460B5] focus:border-[#5460B5]">
                            <option value="" selected disabled>Pilih Kompetensi MK</option>
                            <option value="pendukung">Pendukung</option>
                            <option value="utama">Utama</option>
                        </select>
                    </div>
                </div>
            </div>


            <div class="flex justify-end space-x-4 mt-8">
                <a href="{{ route('admin.matakuliah.index') }}"
                    class="bg-gray-400 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition duration-200">
                    Kembali
                </a>
                <button type="submit"
                    class="bg-[#5460B5] hover:bg-[#424a8f] text-white px-6 py-2 rounded-lg transition duration-200">
                    Simpan
                </button>
            </div>
        </form>
    </div>

@endsection
