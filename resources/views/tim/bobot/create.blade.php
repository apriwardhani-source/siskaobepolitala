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
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 tracking-tight">Tambah Bobot MK - CPL</h1>
                    <p class="mt-1 text-sm text-gray-600">
                        Atur bobot kontribusi mata kuliah terhadap CPL. Total bobot untuk satu mata kuliah harus 100%.
                    </p>
                </div>
            </div>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
            <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-600">
                <h2 class="text-lg font-semibold text-white flex items-center">
                    <i class="fas fa-plus-circle mr-2 text-sm"></i>
                    Formulir Tambah Bobot MK - CPL
                </h2>
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
                            <button onclick="document.getElementById('alert').remove()"
                                    class="ml-4 text-red-400 hover:text-red-600 focus:outline-none">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                @endif

                <form action="{{ route('tim.bobot.store') }}" method="POST" id="bobotForm" class="space-y-6">
                    @csrf

                    <!-- Pilih MK -->
                    <div class="space-y-2">
                        <label for="kode_mk" class="block text-sm font-semibold text-gray-800">
                            Pilih Mata Kuliah
                        </label>
                        <select id="kode_mk" name="kode_mk"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                required>
                            <option value="">-- Pilih Mata Kuliah --</option>
                            @foreach ($mataKuliahs as $mk)
                                <option value="{{ $mk->kode_mk }}">
                                    {{ $mk->kode_mk }} - {{ $mk->nama_mk }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Notifikasi jika semua CPL sudah diberi bobot --}}
                    <div id="notifSudahAda"
                         class="hidden mb-5 rounded-lg bg-red-50 border-l-4 border-red-500 p-4 shadow-sm">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-red-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="flex-1 text-sm text-red-700">
                                Bobot untuk mata kuliah ini sudah ditambahkan sebelumnya atau semua CPL sudah memiliki bobot.
                            </div>
                            <button type="button"
                                    onclick="document.getElementById('notifSudahAda').classList.add('hidden')"
                                    class="ml-4 text-red-400 hover:text-red-600 focus:outline-none">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Seksi CPL & Bobot -->
                    <div id="cplSection" class="mt-4 hidden">
                        <div class="flex items-center justify-between mb-2">
                            <label class="block text-sm font-semibold text-gray-800">
                                Atur Bobot CPL (Total harus 100%)
                            </label>
                            <span class="text-xs text-gray-500">
                                Total Bobot: <span id="totalBobot" class="font-semibold text-blue-700">0%</span>
                            </span>
                        </div>
                        <div id="loadingCPL" class="mt-2 text-sm text-blue-500 italic">Memuat daftar CPL...</div>
                        <div id="cplList"
                             class="mt-3 border border-gray-200 rounded-lg p-4 bg-gray-50 max-h-[320px] overflow-y-auto space-y-2"></div>
                        <p class="mt-2 text-xs text-blue-600">
                            Gunakan tombol <span class="font-semibold">Bagi Rata</span> untuk mendistribusikan bobot secara otomatis.
                        </p>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="pt-4 flex justify-end">
                        <button type="submit"
                                class="inline-flex items-center px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200 disabled:opacity-50"
                                id="submitBtn" disabled>
                            <i class="fas fa-save mr-2 text-xs"></i>
                            Simpan Bobot
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

    @push('scripts')
        <script>
            const mkSelect = document.getElementById('kode_mk');
            const cplList = document.getElementById('cplList');
            const cplSection = document.getElementById('cplSection');
            const loadingCPL = document.getElementById('loadingCPL');
            const totalBobot = document.getElementById('totalBobot');
            const submitBtn = document.getElementById('submitBtn');
            const notifSudahAda = document.getElementById('notifSudahAda');

            mkSelect.addEventListener('change', function() {
                const kodeMK = this.value;
                if (!kodeMK) {
                    cplSection.classList.add('hidden');
                    cplList.innerHTML = '';
                    totalBobot.textContent = '0%';
                    submitBtn.disabled = true;
                    notifSudahAda.classList.add('hidden');
                    return;
                }

                cplSection.classList.remove('hidden');
                loadingCPL.classList.remove('hidden');
                cplList.innerHTML = '';
                notifSudahAda.classList.add('hidden');

                fetch("{{ route('tim.bobot.getCPLByMK') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            kode_mk: kodeMK
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        loadingCPL.classList.add('hidden');
                        cplList.innerHTML = '';

                        if (data.length === 0) {
                            cplList.innerHTML =
                                '<div class="text-red-500 italic">Tidak ada CPL terkait atau semua CPL sudah diberi bobot</div>';
                            notifSudahAda.classList.remove('hidden');
                            submitBtn.disabled = true;
                            return;
                        } else {
                            notifSudahAda.classList.add('hidden');
                        }

                        data.forEach((cpl, index) => {
                            const cplItem = document.createElement('div');
                            cplItem.className =
                                'mb-3 flex items-center justify-between bg-white p-3 border rounded hover:bg-blue-50';

                            cplItem.innerHTML = `
                    <div class="flex-1">
                        <strong>${cpl.kode_cpl}</strong> - ${cpl.deskripsi_cpl}
                    </div>
                    <input type="number" name="bobot[${cpl.id_cpl}]" min="0" max="100" value="0"
                        class="w-24 p-2 border rounded text-center bobot-input">
                    <input type="hidden" name="id_cpl[]" value="${cpl.id_cpl}">
                `;

                            cplList.appendChild(cplItem);
                        });

                        cplList.innerHTML += `
                <div class="mt-4">
                    <button type="button" id="distributeBtn"
                        class="text-sm text-yellow-600 hover:text-yellow-800">Bagi Rata</button>
                </div>`;

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
                    })
                    .catch(err => {
                        loadingCPL.classList.add('hidden');
                        cplList.innerHTML = '<div class="text-red-500 italic">Terjadi kesalahan</div>';
                        console.error(err);
                    });
            });

            function updateTotal() {
                let total = 0;
                document.querySelectorAll('.bobot-input').forEach(input => {
                    total += parseFloat(input.value) || 0;
                });
                totalBobot.textContent = total + '%';
                submitBtn.disabled = total !== 100;
            }

            document.getElementById('bobotForm').addEventListener('submit', function(e) {
                const total = parseFloat(totalBobot.textContent);
                if (total !== 100) {
                    e.preventDefault();
                    alert('Total bobot harus 100%');
                }
            });
        </script>
    @endpush
@endsection
