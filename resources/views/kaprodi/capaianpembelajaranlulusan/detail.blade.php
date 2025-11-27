@extends('layouts.app')

@section('content')

    <div class="mx-4 md:mx-20 mt-6">
        <h2 class="font-extrabold text-3xl mb-5 text-center">Detail Capaian Pembelajaran Lulusan</h2>
        <hr class="border-t-2 md:border-t-4 border-black my-3 md:my-4 mx-auto">

        @if (!empty($selectedProfilLulusans))
            <div class="mt-6 mb-8">
                <h3 class="text-xl font-semibold mb-3">Profil Lulusan Terkait</h3>
                <div class="space-y-2">
                    @foreach ($selectedProfilLulusans as $id_pl)
                        @php
                            $plDetail = $profilLulusans->firstWhere('id_pl', $id_pl);
                        @endphp
                        @if ($plDetail)
                            <div class="w-full p-3 border border-gray-300 rounded-lg bg-gray-50 text-sm">
                                <span class="font-semibold mr-2">{{ $plDetail->kode_pl }}</span>
                                <span class="text-gray-700">{{ $plDetail->deskripsi_pl }}</span>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif

        <div class="space-y-5 mb-10">
            <div>
                <p class="text-sm font-semibold text-gray-600 mb-1">Kode CPL</p>
                <div class="w-full p-3 border border-gray-300 rounded-lg bg-gray-50 font-semibold">
                    {{ $id_cpl->kode_cpl }}
                </div>
            </div>

            <div>
                <p class="text-sm font-semibold text-gray-600 mb-1">Deskripsi CPL</p>
                <div class="w-full p-3 border border-gray-300 rounded-lg bg-gray-50 text-sm leading-relaxed">
                    {{ $id_cpl->deskripsi_cpl }}
                </div>
            </div>

            <div>
                <p class="text-sm font-semibold text-gray-600 mb-1">Status CPL</p>
                <div class="w-full p-3 border border-gray-300 rounded-lg bg-gray-50 text-sm">
                    @php
                        $statusLabel = $id_cpl->status_cpl === 'Kompetensi Utama Bidang' ? 'Utama' : 'Tambahan';
                    @endphp
                    {{ $statusLabel }}
                </div>
            </div>
        </div>

        <a href="{{ route('kaprodi.capaianpembelajaranlulusan.index') }}"
           class="inline-flex items-center bg-gray-700 text-white font-semibold hover:bg-gray-800 px-5 py-2.5 rounded-lg">
            Kembali
        </a>
    </div>

@endsection
