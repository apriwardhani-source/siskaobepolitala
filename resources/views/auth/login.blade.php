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
                    <input type="email" id="email" name="email" class="form-control glass-input @error('email') is-invalid @enderror"
                        value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3 text-start">
                    <label for="password" class="form-label text-white">Password</label>
                    <input type="password" id="password" name="password" class="form-control glass-input @error('password') is-invalid @enderror"
                        required>
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
@endsection
