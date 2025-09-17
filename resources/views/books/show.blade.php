{{-- resources/views/books/show.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 flex flex-col md:flex-row items-start md:items-center gap-8">
    {{-- Gambar Buku --}}
    <div class="md:w-1/3">
        <img src="{{ asset('storage/' . $book->book_img) }}" alt="{{ $book->title }}" class="w-full rounded-lg shadow-lg">
    </div>

    {{-- Detail Buku & Tombol Pinjam --}}
    <div class="md:w-2/3">
        <h1 class="text-4xl font-bold mb-2">{{ $book->title }}</h1>
        <p class="text-xl text-gray-700 mb-4">Oleh: {{ $book->author->name }}</p>
        
        <div class="mb-4">
            <p><strong>Penerbit:</strong> {{ $book->publisher->name }}</p>
            <p><strong>Tahun Terbit:</strong> {{ $book->year }}</p>
            <p><strong>Kategori:</strong> {{ $book->category->name }}</p>
            <p><strong>Lokasi Rak:</strong> {{ $book->shelf->name }}</p>
        </div>

        @if(session('success'))
            <div class="bg-green-500 text-white p-3 rounded mb-4">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="bg-red-500 text-white p-3 rounded mb-4">{{ session('error') }}</div>
        @endif

        {{-- Blok kondisional tunggal untuk tombol pinjam --}}
        @auth
            @if ($book->isAvailable())
                <form action="{{ route('borrowings.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="book_id" value="{{ $book->id }}">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
                        Pinjam Buku
                    </button>
                </form>
            @else
                <button class="bg-gray-400 text-white font-bold py-3 px-6 rounded-lg cursor-not-allowed">
                    Tidak Tersedia
                </button>
            @endif
        @else
            <p class="text-red-500">Anda harus login untuk meminjam buku.</p>
        @endauth
    </div>
</div>
@endsection