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
    <div class="flex justify-between items-center">
        <h1 class="font-semibold text-xl">Perpustakaan</h1>

        <ul class="flex-1 flex gap-4 items-center justify-center">
            <li>
                <a href="{{ route('home') }}" class="text-gray-700 font-medium hover:underline">Home</a>
            </li>
            <li>
                <a href="{{ route('books.index') }}" class="text-gray-600 hover:text-gray-900 px-3">Daftar Buku</a>
            </li>
            {{-- Tautan "Riwayat Peminjaman" hanya untuk pengguna yang login --}}
            @auth
            <li>
                <a href="{{ route('borrowings.index') }}" class="text-gray-600 hover:text-gray-900 px-3">Riwayat Peminjaman</a>
            </li>
            @endauth
        </ul>
        <ul class="flex gap-4 items-center">
            @guest
            <li>
                <a href="{{ route('login') }}" 
                   class="px-4 py-2 border border-gray-600 text-gray-700 rounded-md hover:bg-gray-100 transition">
                    Login
                </a>
            </li>
            {{-- Tombol Register --}}
            <li>
                <a href="{{ route('register') }}" 
                   class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-900 transition">
                    Register
                </a>
            </li>
            @endguest

            @auth
            {{-- Tombol Logout --}}
            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" 
                        class="px-4 py-2 border border-red-600 text-red-600 rounded-md hover:bg-red-600 hover:text-white transition">
                        Logout
                    </button>
                </form>
            </li>

            <li class="flex items-center gap-3">
                {{-- Nama User --}}
                <span class="text-gray-700 font-medium">
                    {{ Auth::user()->name }}
                </span>

                {{-- Avatar huruf pertama --}}
                <div class="avatar placeholder">
                    <div class="bg-gray-200 text-gray-700 rounded-full w-10 h-10 flex items-center justify-center">
                        <span class="text-lg font-semibold">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </span>
                    </div>
                </div>
            </li>
            @endauth
        </ul>
    </div>
</nav>

<main>
    {{-- Hero --}}
    <div class="hero min-h-screen py-96 relative"
          style="background-image: url('{{ asset('images/buku4.jpg') }}'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-black opacity-60"></div>
        <div class="relative z-10 hero-content text-center text-neutral-content">
            <div class="max-w-lg mx-auto">
                <h1 class="mb-5 text-xl font-semibold text-white md:text-3xl lg:text-4xl">Welcome to Library App</h1>
                <p class="mb-5 text-sm text-white md:text-base">Choose from a wide range of popular books from all the categories you want here.</p>
                <a href="{{ route('books.index') }}" class="px-4 py-2 bg-black text-white rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-300">Check Our Books</a>
            </div>
        </div>
    </div>

    {{-- Buku Terpopuler / Berdasarkan Kategori --}}
    <section id="books" class="py-12 px-4 md:px-8">
        <h2 class="text-2xl font-bold text-center mb-8">
            @isset($category)
                Buku dalam Kategori: {{ $category->name }}
            @else
                Buku Terpopuler
            @endisset
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse($books as $book)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition duration-300 hover:scale-105">
                    <img src="{{ $book->book_img ? asset('storage/' . $book->book_img)  : asset('images/default-book.jpg') }}" alt="{{ $book->title }}" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $book->title }}</h3>
                        <p>Oleh: {{ $book->author->name ?? 'Tidak diketahui' }}</p>
                        <p class="text-sm text-gray-500">Kategori: {{ $book->category->name ?? '-' }}</p>
                        {{-- Tombol "Lihat Detail & Pinjam" --}}
                        <a href="{{ route('books.show', $book->id) }}" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 mt-4 w-full text-center">
                        Lihat Detail & Pinjam
                        </a>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500 col-span-4">Belum ada buku tersedia.</p>
            @endforelse
        </div>

        {{-- Pagination kalau byCategory --}}
        @isset($category)
            <div class="mt-6">
                {{ $books->links() }}
            </div>
        @endisset
    </section>

    {{-- Kategori --}}
    <section class="py-12 px-4 md:px-8 bg-gray-50">
        <h2 class="text-2xl font-bold text-center mb-8">Jelajahi Kategori</h2>
        <div class="flex flex-wrap justify-center gap-4">
            @forelse($categories as $category)
                <a href="{{ route('books.byCategory', $category->id) }}" class="bg-gray-200 text-gray-800 px-6 py-3 rounded-full font-semibold hover:bg-gray-300 transition duration-300">
                    {{ $category->name }}
                </a>
            @empty
                <p class="text-gray-500">Belum ada kategori.</p>
            @endforelse
        </div>
    </section>
    
    {{-- Riwayat Peminjaman (Hanya muncul jika sudah login) --}}
    <section id="borrowings" class="py-12 px-4 md:px-8">
        @auth
            <h2 class="text-2xl font-bold text-center mb-8">Riwayat Peminjaman Anda</h2>
            @if ($borrowings && $borrowings->count() > 0)
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="py-2 px-4 border-b text-left text-gray-700">Judul Buku</th>
                                <th class="py-2 px-4 border-b text-left text-gray-700">Tanggal Pinjam</th>
                                <th class="py-2 px-4 border-b text-left text-gray-700">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($borrowings as $borrowing)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-2 px-4 border-b text-sm text-gray-600">{{ $borrowing->book->title }}</td>
                                    <td class="py-2 px-4 border-b text-sm text-gray-600">{{ $borrowing->borrowed_at->format('d M, Y') }}</td>
                                    <td class="py-2 px-4 border-b text-sm text-gray-600">
                                        @if ($borrowing->returned_at)
                                            <span class="text-green-500">Sudah Kembali</span>
                                        @else
                                            <span class="text-orange-500">Sedang Dipinjam</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-center text-gray-500">Anda belum memiliki riwayat peminjaman.</p>
            @endif
        @endauth
    </section>
</main>

{{-- Footer --}}
<footer class="bg-gray-800 text-white py-8">
    <div class="container mx-auto px-6 text-center">
        <p>&copy; 2025 Perpustakaan Arkan. Hak Cipta Dilindungi.</p>
    </div>
</footer>

{{-- Script Navbar Mobile --}}
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