@extends('layouts.admin.app')

@section('content')

<div class="mx-20 mt-6">
    <h2 class="font-extrabold text-3xl mb-5 text-center">Import Capaian Pembelajaran Lulusan dari Excel</h2>
    <hr class="border-t-2 md:border-t-4 border-black my-3 md:my-4 mx-auto">

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-blue-50 border border-blue-300 rounded-lg p-4 mb-6">
        <div class="flex justify-between items-center mb-2">
            <h3 class="font-bold text-lg">Format Excel yang diharapkan:</h3>
            <a href="{{ route('admin.capaianprofillulusan.import.template') }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Download Template
            </a>
        </div>
        <p class="mb-2">File Excel harus memiliki 2 kolom berikut (pada baris pertama sebagai header):</p>
        <ul class="list-disc ml-6 mb-3">
            <li><strong>kode_cpl</strong> - Kode CPL (maks 10 karakter, harus unique)</li>
            <li><strong>deskripsi_cpl</strong> - Deskripsi lengkap CPL</li>
        </ul>
        <p class="text-sm text-gray-700 mb-2">
            <strong>Contoh:</strong><br>
            kode_cpl: CPL-01<br>
            deskripsi_cpl: Mampu menerapkan pemikiran logis, kritis, inovatif dalam konteks pengembangan atau implementasi ilmu pengetahuan dan teknologi
        </p>
        <p class="text-sm text-gray-600 italic">
            <strong>Catatan:</strong> Kode Prodi akan otomatis diambil dari akun Anda yang sedang login. Status CPL dan Tahun Kurikulum dapat diisi manual setelah import.
        </p>
    </div>

    <form action="{{ route('admin.capaianprofillulusan.import.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label for="file" class="text-xl font-semibold mb-2 block">Pilih File Excel</label>
        <input type="file" id="file" name="file" accept=".xlsx,.xls"
            class="border border-black p-3 w-full rounded-lg mt-1 mb-3 focus:outline-none focus:ring-2 focus:ring-[#5460B5] focus:bg-[#f7faff]"
            required>
        <p class="text-sm text-gray-600 mb-4">Format yang didukung: .xlsx, .xls (maksimal 2MB)</p>

        <div class="flex justify-end space-x-5 mt-[50px]">
            <a href="{{ route('admin.capaianprofillulusan.index') }}" 
               class="px-6 py-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg transition duration-200">
                Kembali
            </a>
            <button type="submit" 
                    class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition duration-200">
                Import Data
            </button>
        </div>
    </form>
</div>
@endsection
