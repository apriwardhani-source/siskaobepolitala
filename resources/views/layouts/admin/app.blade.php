<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Kurikulum OBE')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    
    <!-- Custom Styles -->
    <link rel="stylesheet" href="{{ asset('css/custom-styles.css') }}">
    
    @vite(['resources/js/app.js'])
    
    @stack('styles')
</head>
<body class="bg-gray-100">

    <!-- Navbar Component -->
    @include('components.navbar')

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-6 mt-32">
        @yield('content')
    </div>

    @stack('scripts')
</body>
</html>
