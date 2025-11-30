@extends('layouts.tim.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">

        <!-- Header ala form CPL admin -->
        <div class="mb-6">
            <a href="{{ route('tim.bobot.index') }}"
               class="inline-flex items-center px-4 py-2 mb-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                <span class="mr-2 text-base leading-none">&larr;</span>
                Kembali
            </a>
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 md:w-14 md:h-14 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-lg">
                    <i class="fas fa-weight-hanging text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 tracking-tight">Edit Bobot MK - CPL</h1>
                    <p class="mt-1 text-sm text-gray-600">
                        Perbarui distribusi bobot mata kuliah terhadap CPL. Total bobot harus tetap 100%.
                    </p>
                </div>
            </div>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
            <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-white flex items-center">
                    <i class="fas fa-edit mr-2 text-sm"></i>
                    Formulir Edit Bobot MK - CPL
                </h2>
                <div class="text-xs text-blue-100">
                    Total Bobot: <span id="totalBobot" class="font-semibold text-white">0%</span>
                </div>
            </div>

            <div class="px-6 py-6">
                @if ($errors->any())
                    <div id="alert" class="mb-5 rounded-lg bg-red-50 border-l-4 border-red-500 p-4 shadow-sm">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-red-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="flex-1">
                                <h3 class="text-sm font-semibold text-red-800 mb-1">Terjadi kesalahan</h3>
                                <p class="text-sm text-red-700">{{ $errors->first() }}</p>
                            </div>
                            <button type="button"
                                    onclick="document.getElementById('alert').remove()"
                                    class="ml-4 text-red-400 hover:text-red-600 focus:outline-none">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                @endif

                <form action="{{ route('tim.bobot.update', ['bobot' => $id_cpl]) }}" method="POST" id="bobotForm" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="id_cpl" value="{{ $id_cpl }}">

                    <!-- CPL Info -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-800">CPL</label>
                        <div class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-sm text-gray-900">
                            {{ $id_cpl }}
                        </div>
                    </div>

                    <!-- Distribusi Bobot MK -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label class="block text-sm font-semibold text-gray-800">
                                Atur Bobot Mata Kuliah (Total harus 100%)
                            </label>
                        </div>
                        <div id="mkList"
                             class="border border-gray-200 rounded-lg p-4 bg-gray-50 max-h-[320px] overflow-y-auto divide-y divide-gray-200">
                            @foreach ($mataKuliahs as $mk)
                                <div class="flex items-center justify-between bg-white px-4 py-3">
                                    <div class="flex-1 pr-4">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded text-xs font-semibold bg-purple-100 text-purple-800">
                                            {{ $mk->kode_mk }}
                                        </span>
                                        <span class="ml-2 text-sm text-gray-900">
                                            {{ $mk->nama_mk }}
                                        </span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-xs text-gray-500">Bobot</span>
                                        <input type="number"
                                               name="bobot[{{ $mk->kode_mk }}]" min="0" max="100"
                                               value="{{ $existingBobots[$mk->kode_mk] ?? 0 }}"
                                               class="w-20 px-3 py-1.5 border border-gray-300 rounded-lg text-center text-sm bobot-input">
                                        <span class="text-xs text-gray-500">%</span>
                                    </div>
                                    <input type="hidden" name="kode_mk[]" value="{{ $mk->kode_mk }}">
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-3 flex items-center justify-between text-xs text-gray-600">
                            <span>Total Bobot: <span id="totalBobotText" class="font-semibold text-blue-700">0%</span></span>
                            <button type="button" id="distributeBtn"
                                    class="text-xs font-semibold text-yellow-600 hover:text-yellow-800">
                                Bagi Rata
                            </button>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="pt-4 flex justify-end">
                        <button type="submit"
                                class="inline-flex items-center px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200 disabled:opacity-50"
                                id="submitBtn">
                            <i class="fas fa-save mr-2 text-xs"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

@push('scripts')
    <script>
        const totalBobotElement = document.getElementById('totalBobot');
        const totalBobotText = document.getElementById('totalBobotText');
        const submitBtn = document.getElementById('submitBtn');

            function updateTotal() {
                let total = 0;
                document.querySelectorAll('.bobot-input').forEach(input => {
                    total += parseFloat(input.value) || 0;
                });
                const label = total + '%';
                if (totalBobotElement) {
                    totalBobotElement.textContent = label;
                }
                if (totalBobotText) {
                    totalBobotText.textContent = label;
                }
                submitBtn.disabled = total !== 100;
            }

            document.querySelectorAll('.bobot-input').forEach(input => {
                input.addEventListener('input', updateTotal);
                input.addEventListener('change', updateTotal);
            });

            document.getElementById('distributeBtn').addEventListener('click', () => {
                const inputs = document.querySelectorAll('.bobot-input');
                const equal = Math.floor(100 / inputs.length);
                const rem = 100 % inputs.length;
                inputs.forEach((input, i) => input.value = equal + (i < rem ? 1 : 0));
                updateTotal();
            });

            document.getElementById('bobotForm').addEventListener('submit', function(e) {
                const total = parseFloat((totalBobotElement?.textContent || '0').replace('%',''));
                if (total !== 100) {
                    e.preventDefault();
                    alert('Total bobot harus 100%');
                }
            });

            updateTotal();
        </script>
    @endpush
@endsection
