<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Perpustakaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-gray-900 px-3">Logout</button>
                    </form>
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

</body>
</html>