<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- Tambahkan ini jika kamu menggunakan request AJAX -->
    <title>{{ config('app.name', 'Laravel App') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"> <!-- Opsional: Font Awesome untuk ikon -->

    <style>
        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
            background: url("{{ asset('images/background_login.png') }}") no-repeat center center fixed;
            background-size: cover;
        }
     

        /* Gaya untuk Header/Navbar Glass */
        .header-nav {
            position: sticky; /* Buat header tetap di atas saat scroll */
            top: 0;
            z-index: 1000; /* Agar muncul di atas konten lain */
            width: 100%;
            padding: 1rem 2rem; /* Atur padding */
            background: rgba(255, 255, 255, 0.15); /* Warna transparan untuk efek glass */
            backdrop-filter: blur(12px); /* Efek blur */
            -webkit-backdrop-filter: blur(12px); /* Untuk Webkit */
            border-bottom: 1px solid rgba(255, 255, 255, 0.18); /* Garis bawah halus */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); /* Bayangan halus */
            display: flex;
            justify-content: space-between; /* Sejajarkan kiri dan kanan */
            align-items: center;
        }

        .header-nav h2 {
            margin: 0;
            font-weight: bold;
            font-size: 1.5rem;
            color: white; /* Warna teks untuk kontras */
        }

        .nav-menu {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex; /* Buat menu horizontal */
            gap: 1rem; /* Jarak antar item menu */
        }

        .nav-menu li {
            display: inline;
        }

        .nav-menu a, .nav-menu button {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem; /* Atur padding */
            border-radius: 8px; /* Sudut melengkung */
            background: transparent;
            border: none;
            transition: background 0.3s;
            font-size: 1rem; /* Atur ukuran font */
            display: block; /* Pastikan elemen mengambil lebar penuh item li */
        }

        .nav-menu a:hover, .nav-menu button:hover {
            background: rgba(255, 255, 255, 0.2);
            text-decoration: none; /* Pastikan tidak ada garis bawah saat hover */
        }

        /* Gaya untuk konten utama */
        .content {
            padding: 30px; /* Jaga jarak dari header */
            /* Tidak perlu margin-left karena tidak ada sidebar */
        }

        /* Gaya untuk glass card di konten utama */
        .glass-card {
            background: rgba(255, 255, 255, 0.15); /* Warna transparan untuk efek glass */
            backdrop-filter: blur(12px); /* Kurangi blur sedikit */
            -webkit-backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1); /* Kurangi shadow untuk tampilan lebih datar */
            border: 1px solid rgba(255, 255, 255, 0.18);
            color: #333; /* Pastikan teks di dalam card tetap gelap */
        }

        /* Gaya untuk link di dalam glass-card agar kontras */
        .glass-card a {
            color: #007bff;
        }

        .glass-card a:hover {
            color: #0056b3;
        }

        /* Gaya untuk link kartu dashboard */
        .glass-card-link {
            text-decoration: none;
            color: inherit;
            display: block; /* Pastikan link mengambil seluruh area kartu */
        }

    </style>
</head>
<body>
    {{-- Header/Navbar --}}
    @include('layouts.nav') <!-- Ganti dengan include nav baru -->

    {{-- Konten Utama --}}
    <div class="content">
        @yield('content')
    </div>

    <!-- Bootstrap JS (jika diperlukan untuk komponen JS seperti dropdown) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>