<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --brand-1: #0B6AA9;
            --brand-2: #2FB3DA;
            --brand-3: #8EC5FF;
            --brand-ring: rgba(15,130,200,0.35);
        }

        /* Motion */
        @keyframes fadeIn { from {opacity: 0} to {opacity: 1} }
        @keyframes slideUp { from {transform: translateY(12px); opacity: 0} to {transform: translateY(0); opacity: 1} }
        @keyframes pulseSoft { 0% { box-shadow: 0 0 0 0 rgba(48,148,198,0.25) } 70% { box-shadow: 0 0 0 12px rgba(48,148,198,0) } 100% { box-shadow: 0 0 0 0 rgba(48,148,198,0) } }
        .animate-fadeIn { animation: fadeIn .6s ease-out both }
        .animate-slideUp { animation: slideUp .6s ease-out both }
        .btn-soft-pulse:hover { animation: pulseSoft 1.2s ease-out }
        .transition-smooth { transition: all .2s ease }
        .focus-glow:focus { box-shadow: 0 0 0 4px rgba(107,114,128,0.28) }

        /* Background photo */
        .bg-photo { position: fixed; inset:0; z-index:-2; 
            /* lighten overlay so photo shows more */
            background-image: linear-gradient(180deg, rgba(6,28,61,.35), rgba(6,28,61,.35)), url('/image/bg-kampus.jpg');
            background-size: cover; background-position: center; background-repeat: no-repeat; }

        /* MORE TRANSPARENT glass */
        .glass { position: relative; overflow:hidden; border-radius:18px;
            background: rgba(255,255,255,0.06); /* was 0.10 */
            border: 1px solid rgba(255,255,255,0.30); /* was 0.40 */
            backdrop-filter: blur(24px) saturate(180%);
            -webkit-backdrop-filter: blur(24px) saturate(180%);
            box-shadow: 0 10px 26px rgba(2,6,23,0.16), 0 1px 0 rgba(255,255,255,0.18) inset, 0 0 0 1px rgba(255,255,255,0.05) inset;
        }
        .glass::before { content:""; position:absolute; inset:0; background: radial-gradient(120% 60% at 0% 0%, rgba(255,255,255,0.18), rgba(255,255,255,0) 60%); pointer-events:none; }
        .card-wrap { padding:1px; border-radius:18px; background: linear-gradient(120deg, rgba(156,163,175,0.25), rgba(229,231,235,0.15)); }
        .divider-gradient { height:4px; background: linear-gradient(90deg, rgba(156,163,175,0.75), rgba(229,231,235,0.75)); border-radius:9999px }
        .btn-brand { background: linear-gradient(90deg, var(--brand-1), var(--brand-2)); color:#fff; }
        .btn-brand:hover { filter: brightness(1.05); }
        .link-muted { color: rgba(248,250,252,0.8); }
        .link-muted:hover { color: rgba(255,255,255,0.95); text-decoration: underline; }

        @media (prefers-reduced-motion: reduce) { .animate-fadeIn, .animate-slideUp, .btn-soft-pulse:hover { animation:none } .transition-smooth { transition:none } }
            /* HD hero image (uses image-set if available) */
        .hero-bg { background-image: url('/image/Politala.jpeg');
            background-image: -webkit-image-set(url('/image/Politala.jpeg') 1x, url('/image/Politala@2x.jpeg') 2x, url('/image/Politala@3x.jpeg') 3x);
            background-image: image-set(url('/image/Politala.jpeg') 1x, url('/image/Politala@2x.jpeg') 2x, url('/image/Politala@3x.jpeg') 3x);
            background-size: cover; background-position: center; background-repeat: no-repeat;
            filter: brightness(1.12) contrast(1.08) saturate(1.2);
        }
    </style>
</head>
<body class="min-h-screen">

    <!-- Photo background -->
    <div class="bg-photo" aria-hidden="true" style="background-image: linear-gradient(180deg, rgba(6,28,61,.35), rgba(6,28,61,.35)), url('{{ asset('image/bg-kampus.jpg') }}');"></div>

    <!-- Subtle grain overlay -->
    <div aria-hidden="true" class="fixed inset-0 pointer-events-none opacity-[.04] mix-blend-overlay" style="background-image: radial-gradient(circle at 1px 1px, rgba(0,0,0,.6) 1px, transparent 1px); background-size: 6px 6px;"></div>

    <div class="fixed top-4 left-4 z-50">
        <a href="{{ url("/") }}" class="flex items-center text-white/90 bg-black/20 rounded-full px-3 py-2 shadow-md transition-all duration-300 hover:bg-black/30">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
    </div>

    <div class="min-h-screen flex items-center justify-center py-8 px-4 sm:px-6 lg:px-8">
      <div class="card-wrap w-full max-w-4xl animate-fadeIn shadow-2xl">
        <div class="glass overflow-hidden flex flex-col md:flex-row">
        
          <!-- Gambar / Hero -->
          <div class="md:w-1/2 w-full h-64 md:h-auto bg-cover bg-center relative" style="background-image: url('{{ asset('image/Politala.jpeg') }}'); filter: brightness(1.12) contrast(1.08) saturate(1.2);">
            <div class="absolute inset-0" style="background: linear-gradient(180deg, rgba(255,255,255,0.02), rgba(0,0,0,0.12));"></div>
            <div class="absolute bottom-4 left-4 right-4 text-white text-left animate-slideUp">
                <h4 class="text-xs sm:text-sm md:text-base mb-1 opacity-90">Selamat Datang</h4>
                <div class="divider-gradient w-1/5 sm:w-1/5 mb-2"></div>
                <h2 class="text-lg sm:text-xl md:text-2xl font-semibold mb-1 leading-tight">Sistem Kurikulum Berbasis OBE</h2>
                <h3 class="text-sm sm:text-base md:text-lg font-bold leading-tight">Politeknik Negeri Tanah Laut</h3>
            </div>
          </div>
        
          <!-- Form Card -->
          <div class="w-full md:w-1/2 p-6 sm:p-8 flex flex-col justify-center h-full">
            <h1 class="text-2xl sm:text-3xl font-bold text-center text-gray-100 mb-2 tracking-tight animate-slideUp">Masuk Akun</h1>
            <div class="divider-gradient mx-auto w-1/3 mb-3 animate-fadeIn"></div>
            <p class="text-center font-medium text-sm sm:text-base mb-4 text-gray-100/90">Sistem Informasi Penyusun Kurikulum Berbasis OBE</p>
            
            @if($errors->any())
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    showToast("{{ $errors->first() }}", "error");
                });
            </script>
            @endif
            
            <form action="{{ route("login.post") }}" method="POST" class="space-y-4" aria-describedby="form-help" novalidate>
                @csrf
                <div>
                    <label for="email" class="block text-gray-100 font-medium">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none mt-1">
                            <i class="fas fa-envelope text-slate-600"></i>
                        </div>
                        <input id="email" type="email" name="email" inputmode="email" autocomplete="email" autocapitalize="none"
                               value="{{ old("email") }}"
                               class="w-full border @error("email") border-red-400 @else border-white/60 @enderror rounded-lg px-3 py-3 mt-1 pl-10 focus:outline-none focus:ring-2 focus-glow transition-smooth bg-white/80 text-gray-900 placeholder:text-slate-500"
                               required placeholder="nama@email.com">
                    </div>
                    @error("email")
                        <p id="emailHelp" class="text-red-300 text-xs mt-1 animate-slideUp">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password" class="block text-gray-100 font-medium">Kata Sandi</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none mt-1">
                            <i class="fas fa-lock text-slate-600"></i>
                        </div>
                        <input id="password" type="password" name="password" autocomplete="current-password"
                               class="w-full border @error("password") border-red-400 @else border-white/60 @enderror rounded-lg px-3 py-3 mt-1 pl-10 pr-10 focus:outline-none focus:ring-2 focus-glow transition-smooth bg-white/80 text-gray-900 placeholder:text-slate-500"
                               required placeholder="Masukkan password">
                        <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-600 hover:text-white transition-smooth" aria-label="Tampilkan/sembunyikan password" aria-pressed="false">
                            <i class="far fa-eye" id="togglePasswordIcon"></i>
                        </button>
                    </div>
                    @error("password")
                        <p class="text-red-300 text-xs mt-1 animate-slideUp">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between text-sm text-gray-100">
                    <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                        <input type="checkbox" class="rounded border-white/40 bg-white/10 text-white focus:ring-white/30 transition-smooth">
                        <span>Ingat saya</span>
                    </label>
                    <a href="/forgot-password" class="text-gray-100/90 hover:text-white">Lupa password?</a>
                </div>

                <button type="submit" id="submitBtn"
                        class="btn-brand w-full py-2.5 rounded-lg active:scale-[.99] transition-smooth btn-soft-pulse flex items-center justify-center gap-2 shadow-md">
                    <span id="submitText">Masuk</span>
                    <svg id="submitSpinner" class="animate-spin h-4 w-4 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                </button>

                <!-- Divider -->
                <div class="relative my-4">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-100/30"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 text-gray-100/70 bg-transparent">atau</span>
                    </div>
                </div>

                <!-- Google SSO Button -->
                <a href="{{ route('auth.google') }}"
                   class="w-full flex items-center justify-center gap-3 py-2.5 px-4 bg-white hover:bg-gray-50 text-gray-800 font-medium rounded-lg border border-gray-300 shadow-sm transition-smooth active:scale-[.99]">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    <span>Masuk dengan Google</span>
                </a>

                <p class="text-center mt-4">
                    <a href="/signup" class="text-gray-100/90 hover:text-white">Belum punya akun? Daftar</a>
                </p>
                <p id="form-help" class="sr-only">Masukkan email dan kata sandi Anda untuk masuk.</p>
            </form>
          </div>
        </div>
      </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function showToast(message, type = "success") { const Toast = Swal.mixin({ toast: true, position: "top", showConfirmButton: false, timer: 2000, timerProgressBar: true, didOpen: (t) => { t.addEventListener("mouseenter", Swal.stopTimer); t.addEventListener("mouseleave", Swal.resumeTimer); } }); Toast.fire({ icon: type, title: message }); }

        document.addEventListener("DOMContentLoaded", function() {
        @if($errors->any())
            Swal.fire({ icon: "error", title: "{{ $errors->first() }}", showConfirmButton: false, timer: 2000, toast: true, position: "top" });
        @endif
        
        @if(session("error"))
            Swal.fire({ icon: "error", title: "{{ session("error") }}", showConfirmButton: false, timer: 2000, toast: true, position: "top" });
        @endif

        const toggleBtn = document.getElementById("togglePassword");
        const pwd = document.getElementById("password");
        const icon = document.getElementById("togglePasswordIcon");
        if (toggleBtn && pwd && icon) { toggleBtn.addEventListener("click", () => { const show = pwd.getAttribute("type") === "password"; pwd.setAttribute("type", show ? "text" : "password"); icon.classList.toggle("fa-eye"); icon.classList.toggle("fa-eye-slash"); toggleBtn.setAttribute("aria-pressed", String(show)); }); }

        const form = document.querySelector("form"); const submitBtn = document.getElementById("submitBtn"); const submitText = document.getElementById("submitText"); const submitSpinner = document.getElementById("submitSpinner");
        if (form && submitBtn && submitText && submitSpinner) { form.addEventListener("submit", () => { submitBtn.disabled = true; submitSpinner.classList.remove("hidden"); submitText.textContent = "Memproses..."; }); }
    });
    </script>
</body>
</html>



