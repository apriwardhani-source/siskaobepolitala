@extends('layouts.tim.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-full mx-auto">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Pemenuhan CPL</h1>
            <p class="mt-2 text-sm text-gray-600">Peta pemenuhan capaian profil lulusan per semester</p>
        </div>

        <!-- Main Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
            
            <!-- Info -->
            <div class="px-6 py-4 bg-blue-50 border-b border-blue-200">
                <p class="text-sm text-blue-800">
                    <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <strong>Tip:</strong> Arahkan cursor pada kode CPL untuk melihat deskripsi lengkap
                </p>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-gray-700 to-gray-800 sticky top-0">
                        <tr>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider border-r border-gray-600 sticky left-0 bg-gradient-to-r from-gray-700 to-gray-800 z-10">
                                CPL
                            </th>
                            @for ($i = 1; $i <= 8; $i++)
                                <th class="px-4 py-4 text-center text-xs font-semibold text-gray-100 uppercase tracking-wider border-r border-gray-600">
                                    Semester {{ $i }}
                                </th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($petaCPL as $index => $item)
                            <tr class="hover:bg-blue-50 transition-colors duration-150 {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                                <td class="px-6 py-4 border-r border-gray-200 sticky left-0 z-10 {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                                    <div class="relative group">
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-blue-100 text-blue-800 cursor-help">
                                            {{ $item['label'] }}
                                        </span>
                                        
                                        <!-- Tooltip -->
                                        <div class="absolute left-1/2 -translate-x-1/2 bottom-full mb-2 hidden group-hover:block w-80 bg-gray-900 text-white text-sm rounded-lg shadow-2xl z-50 animate-fade-in">
                                            <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-t-lg px-4 py-2 font-bold">
                                                {{ $item['prodi'] }}
                                            </div>
                                            <div class="px-4 py-3 text-left leading-relaxed">
                                                {{ $item['deskripsi_cpl'] }}
                                            </div>
                                            <!-- Arrow -->
                                            <div class="absolute left-1/2 -translate-x-1/2 top-full">
                                                <div class="border-8 border-transparent border-t-gray-900"></div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                @for ($i = 1; $i <= 8; $i++)
                                    <td class="px-4 py-4 border-r border-gray-200 text-center align-top">
                                        @if (!empty($item['semester']['Semester ' . $i]))
                                            <div class="flex flex-wrap gap-1 justify-center">
                                                @foreach($item['semester']['Semester ' . $i] as $mk)
                                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-800">
                                                        {{ $mk }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-gray-400 text-xs">-</span>
                                        @endif
                                    </td>
                                @endfor
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

@push('styles')
<style>
@keyframes fade-in {
    from { opacity: 0; transform: translateY(-5px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-fade-in {
    animation: fade-in 0.2s ease-out;
}

/* Sticky column shadow */
.sticky {
    box-shadow: 2px 0 5px rgba(0,0,0,0.1);
}
</style>
@endpush
@endsection
