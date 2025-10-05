@extends('layouts.auth')

@section('content')
    {{-- Bagian kiri --}}
    <div class="auth-left">
        <img src="{{ asset('images/politala-logo.png') }}" alt="Logo">
        <h2>{{ config('app.name', 'Aplikasi Kampus') }}</h2>
        <p>Selamat datang kembali! Silakan login dengan akun Google atau akun kampus Anda</p>
    </div>

    {{-- Bagian kanan --}}
    <div class="auth-right">
        <div class="auth-card text-center">
            <h4 class="mb-4 text-white">Masuk ke Akun</h4>

            {{-- Tombol login Google --}}
            <a href="{{ route('auth.google') }}" class="btn btn-google w-100 mb-3">
                <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google Logo">
                Masuk dengan Google
            </a>

            <div class="text-white-50 my-3">atau</div>

            {{-- Form login manual --}}
            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                <div class="mb-3 text-start">
                    <label for="email" class="form-label text-white">Email</label>
                    <input type="email" id="email" name="email"
                        class="form-control glass-input @error('email') is-invalid @enderror"
                        value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Input password dengan ikon mata --}}
                <div class="mb-3 text-start position-relative">
                    <label for="password" class="form-label text-white">Password</label>
                    <div class="position-relative">
                        <input type="password" id="password" name="password"
                            class="form-control glass-input pe-5 @error('password') is-invalid @enderror" required>
                        <button type="button" class="btn btn-sm bg-transparent border-0 position-absolute top-50 end-0 translate-middle-y me-2 toggle-password" tabindex="-1">
                            <i class="fas fa-eye" style="color: #ccc;"></i>
                        </button>
                    </div>
                    @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember">
                        <label class="form-check-label text-white-50" for="remember">Ingat saya</label>
                    </div>
                    <a href="#" class="text-white small">Lupa password?</a>
                </div>

                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>

            <p class="small text-white-50 mt-4">
                Dengan masuk, Anda setuju dengan 
                <a href="#" class="text-white">Syarat & Ketentuan</a> 
                dan <a href="#" class="text-white">Kebijakan Privasi</a>.
            </p>
        </div>
    </div>

    {{-- Script toggle password --}}
    <script>
        const toggleButton = document.querySelector('.toggle-password');
        const toggleIcon = toggleButton.querySelector('i');
        const passwordInput = document.querySelector('#password');

        toggleButton.addEventListener('click', (e) => {
            e.preventDefault(); // Hindari form refresh
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';

            toggleIcon.classList.toggle('fa-eye');
            toggleIcon.classList.toggle('fa-eye-slash');
        });
    </script>

    {{-- Font Awesome CDN --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
@endsection
