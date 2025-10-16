<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sign-Up</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
    :root {
      --brand-1: #0B6AA9;
      --brand-2: #2FB3DA;
      --brand-ring: rgba(15,130,200,0.35);
    }
    @keyframes fadeIn { from {opacity:0} to {opacity:1} }
    @keyframes slideUp { from {transform: translateY(12px); opacity:0} to {transform: translateY(0); opacity:1} }
    .animate-fadeIn { animation: fadeIn .6s ease-out both }
    .animate-slideUp { animation: slideUp .6s ease-out both }
    .transition-smooth { transition: all .2s ease }
    .focus-glow:focus { box-shadow: 0 0 0 4px var(--brand-ring) }

    /* Background photo (same as login) */
    .bg-photo { position: fixed; inset:0; z-index:-2;
      background-image: linear-gradient(180deg, rgba(6,28,61,.35), rgba(6,28,61,.35)), url('/image/bg-kampus.jpg');
      background-size: cover; background-position: center; background-repeat: no-repeat; }

    /* Glass container */
    .glass { position: relative; overflow:hidden; border-radius:18px;
      background: rgba(255,255,255,0.06);
      border: 1px solid rgba(255,255,255,0.30);
      backdrop-filter: blur(24px) saturate(180%);
      -webkit-backdrop-filter: blur(24px) saturate(180%);
      box-shadow: 0 10px 26px rgba(2,6,23,0.16), 0 1px 0 rgba(255,255,255,0.18) inset, 0 0 0 1px rgba(255,255,255,0.05) inset;
    }
    .glass::before { content:""; position:absolute; inset:0; background: radial-gradient(120% 60% at 0% 0%, rgba(255,255,255,0.18), rgba(255,255,255,0) 60%); pointer-events:none; }
    .card-wrap { padding:1px; border-radius:18px; background: linear-gradient(120deg, rgba(156,163,175,0.25), rgba(229,231,235,0.15)); }
    .divider-gradient { height:4px; background: linear-gradient(90deg, rgba(156,163,175,0.75), rgba(229,231,235,0.75)); border-radius:9999px }
    .btn-brand { background: linear-gradient(90deg, var(--brand-1), var(--brand-2)); color:#fff; }
    .btn-brand:hover { filter: brightness(1.05); }

    /* Hero image HD (optional @2x/@3x) */
    .hero-bg { background-image: url('/image/Politala.jpeg');
      background-image: -webkit-image-set(url('/image/Politala.jpeg') 1x, url('/image/Politala@2x.jpeg') 2x, url('/image/Politala@3x.jpeg') 3x);
      background-image: image-set(url('/image/Politala.jpeg') 1x, url('/image/Politala@2x.jpeg') 2x, url('/image/Politala@3x.jpeg') 3x);
      background-size: cover; background-position: center; background-repeat: no-repeat;
      filter: brightness(1.12) contrast(1.08) saturate(1.2);
    }
  </style>
</head>
<body class="min-h-screen">

  <div class="bg-photo" aria-hidden="true"></div>
  <div aria-hidden="true" class="fixed inset-0 pointer-events-none opacity-[.04] mix-blend-overlay" style="background-image: radial-gradient(circle at 1px 1px, rgba(0,0,0,.6) 1px, transparent 1px); background-size: 6px 6px;"></div>

  <div class="min-h-screen flex items-center justify-center py-8 px-4">
    <div class="card-wrap w-full max-w-4xl animate-fadeIn shadow-2xl">
      <div class="glass overflow-hidden flex flex-col md:flex-row">

        <!-- Hero -->
        <div class="md:w-1/2 w-full h-64 md:h-auto bg-cover bg-center relative hero-bg">
          <div class="absolute inset-0" style="background: linear-gradient(180deg, rgba(255,255,255,0.02), rgba(0,0,0,0.12));"></div>
          <div class="absolute bottom-4 left-4 right-4 text-white text-left animate-slideUp">
            <h4 class="text-xs sm:text-sm md:text-base mb-1 opacity-90">Selamat Datang</h4>
            <div class="divider-gradient w-1/5 sm:w-1/5 mb-2"></div>
            <h2 class="text-lg sm:text-xl md:text-2xl font-semibold mb-1 leading-tight">Buat Akun Anda</h2>
            <h3 class="text-sm sm:text-base md:text-lg font-bold leading-tight">Politeknik Negeri Tanah Laut</h3>
          </div>
        </div>

        <!-- Form -->
        <div class="md:w-1/2 w-full py-8 px-6 sm:px-10">
          <h1 class="text-3xl font-bold text-gray-100 mb-2 text-center">Daftar Akun</h1>
          <div class="divider-gradient mx-auto w-1/3 mb-5"></div>
          <p class="mb-6 text-gray-100/90 text-center">Isi data di bawah untuk mendaftar.</p>

          @if (session('success'))
            <div id="alert" class="bg-green-500/90 text-white px-4 py-2 rounded-md mb-6 text-center relative">
              <span class="font-bold">{{ session('success') }}</span>
              <button onclick="document.getElementById('alert').style.display='none'" class="absolute top-1 right-3 text-white font-bold text-lg">&times;</button>
            </div>
          @endif

          <form action="{{ route('signup.store') }}" method="POST" novalidate>
            @csrf

            <!-- Name -->
            <div class="mb-4 relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-user text-slate-600"></i>
              </div>
              <input type="text" name="name" placeholder="Nama Lengkap"
                     class="w-full border border-white/60 rounded px-3 py-3 mt-1 pl-10 focus:outline-none focus:ring-2 focus:ring-[color:var(--brand-1)] bg-white/80 text-slate-900 placeholder:text-slate-500"
                     value="{{ old('name') }}" required>
            </div>

            <!-- NIP -->
            <div class="mb-4 relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-id-card text-slate-600"></i>
              </div>
              <input type="text" name="nip" placeholder="NIP"
                     class="w-full border border-white/60 rounded px-3 py-3 mt-1 pl-10 focus:outline-none focus:ring-2 focus:ring-[color:var(--brand-1)] bg-white/80 text-slate-900 placeholder:text-slate-500"
                     value="{{ old('nip') }}" required>
            </div>

            <!-- No HP -->
            <div class="mb-4 relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-phone text-slate-600"></i>
              </div>
              <input type="text" name="nohp" placeholder="Nomor HP"
                     class="w-full border border-white/60 rounded px-3 py-3 mt-1 pl-10 focus:outline-none focus:ring-2 focus:ring-[color:var(--brand-1)] bg-white/80 text-slate-900 placeholder:text-slate-500"
                     value="{{ old('nohp') }}" required>
            </div>

            <!-- Email -->
            <div class="mb-4 relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-envelope text-slate-600"></i>
              </div>
              <input type="email" name="email" placeholder="Email"
                     class="w-full border border-white/60 rounded px-3 py-3 mt-1 pl-10 focus:outline-none focus:ring-2 focus:ring-[color:var(--brand-1)] bg-white/80 text-slate-900 placeholder:text-slate-500"
                     value="{{ old('email') }}" required>
            </div>

            <!-- Password -->
            <div class="mb-4 relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-lock text-slate-600"></i>
              </div>
              <input id="password" type="password" name="password" placeholder="Masukkan Password"
                     class="w-full border border-white/60 rounded px-3 py-3 mt-1 pl-10 pr-10 focus:outline-none focus:ring-2 focus:ring-[color:var(--brand-1)] bg-white/80 text-slate-900 placeholder:text-slate-500"
                     required>
              <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-600 hover:text-slate-800 transition-smooth" aria-label="Tampilkan/sembunyikan password" aria-pressed="false">
                <i class="far fa-eye" id="togglePasswordIcon"></i>
              </button>
            </div>

            <!-- Prodi -->
            <div class="mb-4">
              <label class="block mb-1 text-gray-100">Program Studi</label>
              <select name="kode_prodi" class="w-full border border-white/60 py-3 px-3 rounded bg-white/80 text-slate-900 focus:outline-none focus:ring-2 focus:ring-[color:var(--brand-1)]" required>
                <option value="">-- Pilih Prodi --</option>
                @foreach($prodis as $prodi)
                  <option value="{{ $prodi->kode_prodi }}" {{ old('kode_prodi') == $prodi->kode_prodi ? 'selected' : '' }}>{{ $prodi->nama_prodi }}</option>
                @endforeach
              </select>
            </div>

            <!-- Role -->
            <div class="mb-4">
              <label class="block mb-1 text-gray-100">Peran</label>
              <select name="role" class="w-full border border-white/60 py-3 px-3 rounded bg-white/80 text-slate-900 focus:outline-none focus:ring-2 focus:ring-[color:var(--brand-1)]" required>
                <option value="">-- Pilih Peran --</option>
                <option value="kaprodi" {{ old('role') == 'kaprodi' ? 'selected' : '' }}>Kaprodi</option>
                <option value="tim" {{ old('role') == 'tim' ? 'selected' : '' }}>Admin Prodi</option>
                <option value="dosen" {{ old('role') == 'dosen' ? 'selected' : '' }}>Dosen</option>
              </select>
            </div>

            <div class="mt-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
              <button type="submit" class="btn-brand text-white font-semibold py-2.5 px-7 rounded-lg transition-smooth w-full sm:w-auto">Daftar</button>
              <a href="{{ route('login') }}" class="text-sm text-gray-100/90 hover:text-white text-center sm:text-left">Sudah punya akun?</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Toggle password visibility
    const toggleBtn = document.getElementById('togglePassword');
    const pwd = document.getElementById('password');
    const icon = document.getElementById('togglePasswordIcon');
    if (toggleBtn && pwd && icon) {
      toggleBtn.addEventListener('click', () => {
        const show = pwd.getAttribute('type') === 'password';
        pwd.setAttribute('type', show ? 'text' : 'password');
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
        toggleBtn.setAttribute('aria-pressed', String(show));
      });
    }
  </script>
</body>
</html>
