@extends('layouts.tim.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-full mx-auto">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Pemetaan MK - CPMK - Sub CPMK</h1>
            <p class="mt-2 text-sm text-gray-600">Pemetaan mata kuliah, capaian pembelajaran, dan sub capaian pembelajaran</p>
        </div>

        <!-- Main Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
            
            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-gray-700 to-gray-800">
                        <tr>
                            <th class="px-4 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider w-16">No</th>
                            <th class="px-4 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider w-28">Kode MK</th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-gray-100 uppercase tracking-wider">Nama MK</th>
                            <th class="px-4 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider w-28">Kode CPMK</th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-gray-100 uppercase tracking-wider">Deskripsi CPMK</th>
                            <th class="px-4 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider w-28">Sub CPMK</th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-gray-100 uppercase tracking-wider">Uraian Sub CPMK</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($data as $index => $row)
                            <tr class="hover:bg-blue-50 transition-colors duration-150 {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                                <td class="px-4 py-3 whitespace-nowrap text-center text-sm text-gray-700 font-medium">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold bg-purple-100 text-purple-800">
                                        {{ $row->kode_mk }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    {{ $row->nama_mk }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold bg-blue-100 text-blue-800">
                                        {{ $row->kode_cpmk }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700">
                                    {{ $row->deskripsi_cpmk }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold bg-green-100 text-green-800">
                                        {{ $row->sub_cpmk }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700">
                                    {{ $row->uraian_cpmk }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection
