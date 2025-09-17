{{-- resources/views/home.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Daftar Buku</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach ($books as $book)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <img src="{{ asset('storage/' . $book->book_img) }}" alt="{{ $book->title }}" class="w-full h-48 object-cover">
            <div class="p-4">
                <h2 class="text-xl font-semibold mb-2">{{ $book->title }}</h2>
                <p class="text-gray-600 mb-1">Oleh: {{ $book->author->name }}</p>
                <p class="text-gray-600 mb-4">Kategori: {{ $book->category->name }}</p>
                <a href="{{ route('books.show', $book->id) }}" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Lihat Detail & Pinjam
                </a>
            </div>
        </div>
        @endforeach
    </div>
    <div class="mt-4">
        {{ $books->links() }}
    </div>
</div>
@endsection