@extends('layouts.app')

@section('content')
    <div class="mx-20">
        <h2 class="text-4xl font-extrabold text-center mb-4">Tambah Bobot CPL-MK</h2>
        <hr class="w-full border border-black mb-4">
        @if ($errors->any())
            <div id="alert"
                class="bg-red-500 text-white px-4 py-2 rounded-md mb-6 text-center relative max-w-4xl mx-auto">
                <span class="font-bold">{{ $errors->first() }}</span>
                <button onclick="document.getElementById('alert').style.display='none'"
                    class="absolute top-1 right-3 text-white font-bold text-lg">
                    &times;
                </button>
            </div>
        @endif

        <form action="{{ route('admin.bobot.store') }}" method="POST" id="bobotForm">
            @csrf

            <label for="kode_mk" class="text-xl font-semibold mb-2">Pilih Mata Kuliah</label>
            <select id="kode_mk" name="kode_mk"
                class="border border-black p-3 w-full rounded-lg mt-1 mb-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-[#f7faff]"
                required>
                <option value="">-- Pilih Mata Kuliah --</option>
                @foreach ($mataKuliahs as $mk)
                    <option value="{{ $mk->kode_mk }}">
                        {{ $mk->kode_mk }} - {{ $mk->nama_mk }}
                    </option>
                @endforeach
            </select>

            {{-- Notifikasi jika semua CPL sudah diberi bobot --}}
            <div id="notifSudahAda"
                class="hidden bg-red-500 text-white px-4 py-2 rounded-md mb-6 text-center relative max-w-4xl mx-auto">
                <span class="font-bold">Bobot untuk Mata Kuliah ini sudah ditambahkan sebelumnya.</span>
                <button onclick="document.getElementById('notifSudahAda').style.display='none'"
                    class="absolute top-1 right-3 text-white font-bold text-lg">
                    &times;
                </button>
            </div>

            <div id="cplSection" class="mt-6 hidden">
                <label class="text-xl font-semibold">Atur Bobot CPL (Total harus 100%)</label>
                <div id="loadingCPL" class="mt-3 text-blue-500 italic">Memuat CPL...</div>
                <div id="cplList"
                    class="mt-2 border border-black rounded-lg p-4 bg-gray-50 max-h-[300px] overflow-y-auto"></div>
                <div class="mt-2 text-sm text-gray-600">Total Bobot: <span id="totalBobot">0%</span></div>
                <p class="italic text-blue-600 text-sm mt-1">Gunakan tombol bagi rata jika ingin mendistribusikan secara
                    merata</p>
            </div>

            <button type="submit"
                class="px-4 py-2 bg-green-500 rounded-lg text-white hover:bg-green-600 mt-6 disabled:opacity-50"
                id="submitBtn" disabled>
                Simpan
            </button>
        </form>
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

                fetch("{{ route('admin.bobot.getCPLByMK') }}", {
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
