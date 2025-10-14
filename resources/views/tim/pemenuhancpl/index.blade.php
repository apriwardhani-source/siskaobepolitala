@extends('layouts.tim.app')

@section('content')
<div class="bg-white p-4 md:p-6 lg:p-8 rounded-lg shadow-md mx-2 md:mx-0">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Pemenuhan CPL</h1>
        <hr class="border-t-2 md:border-t-4 border-black my-3 md:my-4 mx-auto">
    </div>

    <table class="w-full overflow-auto border border-gray-300 shadow-md rounded-lg text-center">
            <thead class="bg-green-800 text-white uppercase">
                <tr>
                    <th class="px-4 py-2">CPL</th>
                    @for ($i = 1; $i <= 8; $i++)
                        <th>Semester {{ $i }}</th>
                    @endfor
                </tr>
            </thead>
            <tbody>
                @foreach ($petaCPL as $item)
                    <tr>
                        <td class="border border-b px-4 py-2 relative group">
                            <span class="hover:cursor-help">{{ $item['label'] }}</span>
                            <div
                                class="absolute left-1/2 -translate-x-1/2 top-full mb-4 hidden group-hover:block w-64 bg-black text-white text-sm rounded p-2 z-50 text-center shadow-lg">

                                <div class="bg-gray-600 rounded-t px-2 py-1 font-bold">
                                    {{ $item['prodi'] }}
                                </div>
                                <div class="mt-3 px-2 text-justify">
                                    {{ $item['deskripsi_cpl'] }}
                                </div>
                            </div>
                        </td>
                        @for ($i = 1; $i <= 8; $i++)
                            <td class="border border-b">
                                @if (!empty($item['semester']['Semester ' . $i]))
                                    {!! implode('<br>', $item['semester']['Semester ' . $i]) !!}
                                @else
                                    {{ null }}
                                @endif
                            </td>
                        @endfor
                    </tr>
                @endforeach
            </tbody>
        </table>
        <p class="mt-3 italic text-red-500">*arahkan cursor pada cpl untuk melihat deskripsi*</p>
    </div>
@endsection
