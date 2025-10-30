<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Role - SISKAO</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --brand-1: #0B6AA9;
            --brand-2: #2FB3DA;
        }

        @keyframes fadeIn { from {opacity: 0} to {opacity: 1} }
        @keyframes slideUp { from {transform: translateY(12px); opacity: 0} to {transform: translateY(0); opacity: 1} }
        .animate-fadeIn { animation: fadeIn .6s ease-out both }
        .animate-slideUp { animation: slideUp .6s ease-out both }
        .transition-smooth { transition: all .2s ease }

        .bg-photo { 
            position: fixed; inset:0; z-index:-2;
            background-image: linear-gradient(180deg, rgba(6,28,61,.35), rgba(6,28,61,.35)), url('/image/bg-kampus.jpg');
            background-size: cover; background-position: center; background-repeat: no-repeat;
        }

        .glass {
            position: relative; overflow:hidden; border-radius:18px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.30);
            backdrop-filter: blur(24px) saturate(180%);
            box-shadow: 0 10px 26px rgba(2,6,23,0.16), 0 1px 0 rgba(255,255,255,0.18) inset;
        }
        
        .role-card {
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid rgba(255,255,255,0.3);
        }
        
        .role-card:hover {
            transform: translateY(-4px);
            border-color: var(--brand-2);
            box-shadow: 0 8px 20px rgba(47,179,218,0.3);
        }
        
        .role-card.selected {
            border-color: var(--brand-1);
            background: linear-gradient(135deg, rgba(11,106,169,0.2), rgba(47,179,218,0.2));
            box-shadow: 0 0 0 3px rgba(11,106,169,0.3);
        }

        .btn-brand { 
            background: linear-gradient(90deg, var(--brand-1), var(--brand-2)); 
            color:#fff; 
        }
        .btn-brand:hover { filter: brightness(1.05); }
        .btn-brand:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>
</head>
<body class="min-h-screen">
    
    <div class="bg-photo" aria-hidden="true" style="background-image: linear-gradient(180deg, rgba(6,28,61,.35), rgba(6,28,61,.35)), url('{{ asset('image/bg-kampus.jpg') }}');"></div>

    <div class="min-h-screen flex items-center justify-center py-8 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-4xl animate-fadeIn">
            <div class="glass p-8 sm:p-10">
                
                <!-- Header -->
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-br from-blue-500 to-cyan-500 mb-4 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-white mb-2">Selamat Datang!</h1>
                    <p class="text-gray-200">
                        @if(session('google_user'))
                            <span class="font-semibold">{{ session('google_user')['name'] }}</span>
                        @endif
                    </p>
                    <p class="text-gray-300 mt-2">Silakan pilih role Anda untuk melanjutkan pendaftaran</p>
                </div>

                <form action="{{ route('auth.google.select-role.post') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <!-- Role Selection -->
                    <div>
                        <label class="block text-white font-semibold mb-4 text-center text-lg">Pilih Role</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            
                            <!-- Admin -->
                            <div class="role-card glass p-6 text-center" onclick="selectRole('admin', this)">
                                <input type="radio" name="role" value="admin" id="role-admin" class="hidden" required>
                                <div class="text-4xl mb-3">
                                    <i class="fas fa-user-shield text-red-400"></i>
                                </div>
                                <h3 class="text-white font-bold text-lg mb-2">Admin</h3>
                                <p class="text-gray-300 text-sm">Administrator sistem dengan akses penuh</p>
                            </div>

                            <!-- Wadir1 -->
                            <div class="role-card glass p-6 text-center" onclick="selectRole('wadir1', this)">
                                <input type="radio" name="role" value="wadir1" id="role-wadir1" class="hidden">
                                <div class="text-4xl mb-3">
                                    <i class="fas fa-user-tie text-purple-400"></i>
                                </div>
                                <h3 class="text-white font-bold text-lg mb-2">Wadir 1</h3>
                                <p class="text-gray-300 text-sm">Wakil Direktur Bidang Akademik</p>
                            </div>

                            <!-- Kaprodi -->
                            <div class="role-card glass p-6 text-center" onclick="selectRole('kaprodi', this)">
                                <input type="radio" name="role" value="kaprodi" id="role-kaprodi" class="hidden">
                                <div class="text-4xl mb-3">
                                    <i class="fas fa-chalkboard-teacher text-blue-400"></i>
                                </div>
                                <h3 class="text-white font-bold text-lg mb-2">Kaprodi</h3>
                                <p class="text-gray-300 text-sm">Kepala Program Studi</p>
                            </div>

                            <!-- Tim -->
                            <div class="role-card glass p-6 text-center" onclick="selectRole('tim', this)">
                                <input type="radio" name="role" value="tim" id="role-tim" class="hidden">
                                <div class="text-4xl mb-3">
                                    <i class="fas fa-users text-green-400"></i>
                                </div>
                                <h3 class="text-white font-bold text-lg mb-2">Tim</h3>
                                <p class="text-gray-300 text-sm">Tim Penyusun Kurikulum</p>
                            </div>

                            <!-- Dosen -->
                            <div class="role-card glass p-6 text-center" onclick="selectRole('dosen', this)">
                                <input type="radio" name="role" value="dosen" id="role-dosen" class="hidden">
                                <div class="text-4xl mb-3">
                                    <i class="fas fa-user-graduate text-yellow-400"></i>
                                </div>
                                <h3 class="text-white font-bold text-lg mb-2">Dosen</h3>
                                <p class="text-gray-300 text-sm">Dosen Pengampu Mata Kuliah</p>
                            </div>
                        </div>
                        @error('role')
                            <p class="text-red-300 text-sm mt-2 text-center">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Optional Fields -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                        <div>
                            <label for="nip" class="block text-white font-medium mb-2">NIP (Opsional)</label>
                            <input type="text" name="nip" id="nip" 
                                   class="w-full px-4 py-3 rounded-lg border border-white/40 bg-white/80 text-gray-900 
                                          focus:outline-none focus:ring-2 focus:ring-blue-400 transition-smooth"
                                   placeholder="Nomor Induk Pegawai"
                                   value="{{ old('nip') }}">
                            @error('nip')
                                <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="nohp" class="block text-white font-medium mb-2">No. HP (Opsional)</label>
                            <input type="text" name="nohp" id="nohp" 
                                   class="w-full px-4 py-3 rounded-lg border border-white/40 bg-white/80 text-gray-900 
                                          focus:outline-none focus:ring-2 focus:ring-blue-400 transition-smooth"
                                   placeholder="08xxxxxxxxxx"
                                   value="{{ old('nohp') }}">
                            @error('nohp')
                                <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Info Message -->
                    <div class="glass p-4 border-l-4 border-yellow-400">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-yellow-400 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <p class="text-yellow-100 text-sm font-medium">Perhatian!</p>
                                <p class="text-yellow-200 text-xs mt-1">
                                    Akun Anda akan dalam status <strong>pending</strong> setelah pendaftaran. 
                                    Administrator akan meninjau dan menyetujui akun Anda dalam waktu 1x24 jam.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" id="submitBtn"
                            class="btn-brand w-full py-3 rounded-lg font-semibold text-lg shadow-lg transition-smooth active:scale-[.99]"
                            disabled>
                        <span id="submitText">Pilih Role Terlebih Dahulu</span>
                    </button>

                    <p class="text-center text-gray-300 text-sm">
                        <a href="{{ route('login') }}" class="text-blue-300 hover:text-blue-200 underline">
                            Kembali ke Login
                        </a>
                    </p>
                </form>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let selectedRole = null;
        const submitBtn = document.getElementById('submitBtn');
        const submitText = document.getElementById('submitText');

        function selectRole(role, card) {
            // Remove previous selection
            document.querySelectorAll('.role-card').forEach(c => {
                c.classList.remove('selected');
            });
            
            // Add selection to clicked card
            card.classList.add('selected');
            
            // Check the radio button
            document.getElementById(`role-${role}`).checked = true;
            
            // Enable submit button
            selectedRole = role;
            submitBtn.disabled = false;
            submitText.textContent = `Daftar sebagai ${getRoleName(role)}`;
        }

        function getRoleName(role) {
            const names = {
                'admin': 'Admin',
                'wadir1': 'Wadir 1',
                'kaprodi': 'Kaprodi',
                'tim': 'Tim',
                'dosen': 'Dosen'
            };
            return names[role] || role;
        }

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            if (!selectedRole) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Role Belum Dipilih',
                    text: 'Silakan pilih role terlebih dahulu',
                    toast: true,
                    position: 'top',
                    timer: 2000,
                    showConfirmButton: false
                });
                return false;
            }
            
            submitBtn.disabled = true;
            submitText.textContent = 'Memproses...';
        });

        // Show validation errors
        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal',
                text: '{{ $errors->first() }}',
                toast: true,
                position: 'top',
                timer: 3000,
                showConfirmButton: false
            });
        @endif
    </script>
</body>
</html>
