<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Perpustakaan</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Gaya tambahan atau custom CSS bisa ditambahkan di sini */
    </style>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    {{-- Header atau Navbar --}}
    <nav class="bg-white shadow-md p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ url('/') }}" class="text-xl font-bold text-gray-800">Perpustakaan Arkan</a>
            <div>
                <a href="{{ route('books.index') }}" class="text-gray-600 hover:text-gray-900 px-3">Daftar Buku</a>
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-900 px-3">Beranda</a>
                {{-- Cek apakah pengguna sudah login --}}
                @auth
                    <a href="{{ route('borrowings.index') }}" class="text-gray-600 hover:text-gray-900 px-3">Riwayat Peminjaman</a>
                    <div class="relative inline-block text-left">
                        <button type="button" class="flex items-center text-gray-600 hover:text-gray-900 px-3" onclick="toggleDropdown()">
                            @if(auth()->user()->profile_image)
                                <img src="{{ asset('storage/' . auth()->user()->profile_image) }}"
                                     alt="Profile" class="w-8 h-8 rounded-full mr-2">
                            @else
                                <div class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center mr-2">
                                    <i class="fas fa-user"></i>
                                </div>
                            @endif
                            <span>{{ auth()->user()->name }}</span>
                            <i class="fas fa-chevron-down ml-1 text-xs"></i>
                        </button>
                        <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50">
                            <div class="py-1">
                                <a href="{{ route('settings.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user-cog mr-2"></i>Profile Settings
                                </a>
                                <a href="{{ route('settings.password.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-lock mr-2"></i>Change Password
                                </a>
                                <hr class="my-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 px-3">Login</a>
                    <a href="{{ route('register') }}" class="text-gray-600 hover:text-gray-900 px-3">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Konten Utama --}}
    <main class="py-10">
        @yield('content')
    </main>

    {{-- Footer (Opsional) --}}
    <footer class="bg-gray-800 text-white text-center p-4 mt-8">
        <p>&copy; 2025 Perpustakaan Arkan. All rights reserved.</p>
    </footer>

    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('profileDropdown');
            dropdown.classList.toggle('hidden');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('profileDropdown');
            const button = event.target.closest('button');

            if (!button || !button.onclick || button.onclick.toString().indexOf('toggleDropdown') === -1) {
                dropdown.classList.add('hidden');
            }
        });
    </script>

</body>
</html>
