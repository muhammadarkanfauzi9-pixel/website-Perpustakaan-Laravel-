<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Utama - Perpustakaan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    @vite('resources/css/app.css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>

<body class="bg-gray-100 font-[Poppins]">
    
    {{-- Navbar --}}
    <nav class="bg-white px-4 py-4 md:px-8 lg:py-3 shadow-sm">
        <div class="flex flex-wrap justify-between items-center lg:flex-nowrap">
            <h1 class="font-semibold text-xl">Perpustakaan</h1>
            <button class="block lg:hidden" id="navButton">
                <i class="fas fa-bars"></i>
            </button>
            <ul class="hidden flex-col items-center gap-2 w-full mt-4 lg:flex lg:w-fit lg:flex-row lg:mt-0" id="navMenu">
                {{-- Tautan yang selalu terlihat --}}
                <li class="px-4 py-2 text-sm font-medium transition-all duration-300 rounded hover:bg-gray-200">
                    <a href="{{ route('home') }}">Beranda</a>
                </li>
                <li class="px-4 py-2 text-sm font-medium transition-all duration-300 rounded hover:bg-gray-200">
                    <a href="#">Katalog</a>
                </li>

                {{-- Di dalam navbar --}}
            @auth
            {{-- Tampilan untuk pengguna yang sudah login --}}
            <li class="flex items-center gap-4 lg:ml-4">
            <li class= "px-4 py-2 text-sm font-medium transition-all duration-300 rounded hover:bg-black hover:text-white">
                <a href="{{ route('logout') }}">Logout</a>
            </li>
            <p class="font-medium text-sm text-gray-400">{{ Auth::user()->name }}</p>
            <div class="avatar placeholder">
            <div class="bg-gray-200 text-neutral-content rounded-full w-10 h-10 flex items-center justify-center">
                <span class="text-lg font-semibold text-gray-800">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </span>
            </div>
        </div>
    </li>
@else
    {{-- Tampilan untuk pengguna yang belum login --}}
    <li class="mt-4 flex flex-col gap-4 md:flex-row md:items-center lg:mt-0 lg:ml-4">
        <a href="{{ route('login') }}" class="px-3 py-2 border border-gray-800 rounded text-xs font-medium block w-full transition-all duration-300 hover:bg-gray-800 hover:text-white lg:text-sm text-center">Login</a>
        <a href="{{ route('register') }}" class="px-3 py-2 bg-gray-800 rounded text-xs font-medium text-white block w-full lg:text-sm text-center">Registrasi</a>
    </li>
@endauth
            </ul>
        </div>
    </nav>

    <main>
        {{-- Hero Section (dengan gambar latar belakang) --}}
        <div class="hero min-h-screen py-96 relative"
             style="background-image: url('{{ asset('images/buku4.jpg') }}'); background-size: cover; background-position: center;">
            <div class="absolute inset-0 bg-black opacity-60"></div>
            <div class="relative z-10 hero-content text-center text-neutral-content">
                <div class="max-w-lg mx-auto">
                    <h1 class="mb-5 text-xl font-semibold text-white md:text-3xl lg:text-4xl">Welcome to Library App</h1>
                    <p class="mb-5 text-sm text-white md:text-base">Choose from a wide range of popular books from all the categories you want here.</p>
                    <a href="#" class="btn btn-sm bg-gray-800 text-white">Check Our Books</a>
                </div>
            </div>
        </div>

        {{-- Section Buku Terpopuler --}}
        <section class="py-12 px-4 md:px-8">
            <h2 class="text-2xl font-bold text-center mb-8">Buku Terpopuler</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                {{-- Pastikan variabel $books di passing dari controller --}}
                {{-- Loop ini akan menampilkan data buku --}}
                @foreach($books as $book)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition duration-300 hover:scale-105">
                        <img src="{{ $book['image'] }}" alt="{{ $book['title'] }}" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $book['title'] }}</h3>
                            <p class="text-gray-500 text-sm">Oleh: {{ $book['author'] }}</p>
                            <a href="#" class="mt-4 inline-block text-gray-800 font-semibold hover:underline">Lihat Detail &rarr;</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- Section Kategori --}}
        <section class="py-12 px-4 md:px-8 bg-gray-50">
            <h2 class="text-2xl font-bold text-center mb-8">Jelajahi Kategori</h2>
            <div class="flex flex-wrap justify-center gap-4">
                {{-- Pastikan variabel $categories di passing dari controller --}}
                {{-- Loop ini akan menampilkan data kategori --}}
                @foreach($categories as $category)
                    <a href="#" class="bg-gray-200 text-gray-800 px-6 py-3 rounded-full font-semibold hover:bg-gray-300 transition duration-300">
                        {{ $category }}
                    </a>
                @endforeach
            </div>
        </section>
    </main>

    {{-- Footer --}}
    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-6 text-center">
            <p>&copy; 2025 Perpustakaan Arkan. Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    {{-- Script untuk Navigasi Mobile --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const navButton = document.getElementById('navButton');
            const navMenu = document.getElementById('navMenu');

            navButton.addEventListener('click', () => {
                navMenu.classList.toggle('hidden');
                navMenu.classList.toggle('flex');
            });
        });
    </script>
</body>
</html>