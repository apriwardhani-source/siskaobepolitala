<!DOCTYPE html>
<html>
<head>
    <title>Test Navbar</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-8">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h1 class="text-2xl font-bold mb-4">Debug Info</h1>
            
            @if(auth()->check())
                <div class="space-y-2">
                    <p><strong>User ID:</strong> {{ auth()->user()->id }}</p>
                    <p><strong>Name:</strong> {{ auth()->user()->name }}</p>
                    <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
                    <p><strong>Role:</strong> <span class="px-3 py-1 bg-blue-500 text-white rounded">{{ auth()->user()->role }}</span></p>
                    
                    <hr class="my-4">
                    
                    <h2 class="text-xl font-semibold mb-2">Menu URL untuk Role Ini:</h2>
                    <div class="bg-gray-50 p-4 rounded">
                        @php
                            $role = auth()->user()->role;
                            $routes = [
                                'admin' => 'admin.ranking.index',
                                'wadir1' => 'wadir1.ranking.index',
                                'kaprodi' => 'kaprodi.ranking.index',
                                'tim' => 'tim.ranking.index',
                                'dosen' => 'dosen.ranking.index',
                            ];
                        @endphp
                        
                        @if(isset($routes[$role]))
                            <p class="mb-2"><strong>Route Name:</strong> {{ $routes[$role] }}</p>
                            <p><strong>URL:</strong> <a href="{{ route($routes[$role]) }}" class="text-blue-600 underline">{{ route($routes[$role]) }}</a></p>
                        @else
                            <p class="text-red-600">Role tidak memiliki akses ranking</p>
                        @endif
                    </div>
                    
                    <hr class="my-4">
                    
                    <h2 class="text-xl font-semibold mb-2">Test Link:</h2>
                    <a href="{{ route($routes[$role] ?? 'login') }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        <i class="bi bi-trophy mr-2"></i>Buka Halaman Ranking
                    </a>
                </div>
            @else
                <p class="text-red-600">User tidak login!</p>
            @endif
            
            <hr class="my-4">
            <a href="{{ url('/') }}" class="text-blue-600 underline">← Kembali ke Homepage</a>
        </div>
    </div>
</body>
</html>
