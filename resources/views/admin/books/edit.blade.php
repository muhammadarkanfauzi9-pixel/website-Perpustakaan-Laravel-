@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Edit Book</h1>

    @if ($errors->any())
        <div class="bg-red-500 text-white p-4 rounded-lg mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.books.update', $book) }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded-lg p-6">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="title" class="block text-gray-700 font-bold mb-2">Title</label>
            <input type="text" name="title" id="title" value="{{ old('title', $book->title) }}" required class="shadow border rounded-lg w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        {{-- Pilih Author yang sudah ada --}}
        <div class="mb-4">
            <label for="author_id" class="block text-gray-700 font-bold mb-2">Pilih Author</label>
            <select name="author_id" id="author_id" class="shadow border rounded-lg w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">-- Pilih dari daftar --</option>
                @foreach($authors as $author)
                    <option value="{{ $author->id }}" {{ $book->author_id == $author->id ? 'selected' : '' }}>{{ $author->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Atau masukkan author baru --}}
        <div class="mb-4">
            <label for="author_name" class="block text-gray-700 font-bold mb-2">Atau Tambah Author Baru</label>
            <input type="text" name="author_name" id="author_name" placeholder="Nama author baru" class="shadow border rounded-lg w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="mb-4">
            <label for="year" class="block text-gray-700 font-bold mb-2">Year</label>
            <input type="number" name="year" id="year" value="{{ old('year', $book->year) }}" required class="shadow border rounded-lg w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500" min="1900" max="{{ date('Y') }}">
        </div>

        <div class="mb-4">
            <label for="book_img" class="block text-gray-700 font-bold mb-2">Book Image</label>
            <input type="file" name="book_img" id="book_img" accept="image/*" class="shadow border rounded-lg w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
            @if($book->book_img)
                <div class="mt-4">
                    <p class="text-sm text-gray-600 mb-2">Current Image:</p>
                    <img src="{{ asset('storage/'.$book->book_img) }}" alt="{{ $book->title }}" class="w-32 h-32 object-cover rounded-md shadow-lg">
                </div>
            @endif
        </div>

        <div class="mb-4">
            <label for="publisher_id" class="block text-gray-700 font-bold mb-2">Publisher</label>
            <select name="publisher_id" id="publisher_id" class="shadow border rounded-lg w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @foreach($publishers as $publisher)
                    <option value="{{ $publisher->id }}" @if($book->publisher_id == $publisher->id) selected @endif>{{ $publisher->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="shelf_id" class="block text-gray-700 font-bold mb-2">Shelf</label>
            <select name="shelf_id" id="shelf_id" class="shadow border rounded-lg w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @foreach($shelves as $shelf)
                    <option value="{{ $shelf->id }}" @if($book->shelf_id == $shelf->id) selected @endif>{{ $shelf->name }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="mb-4">
            <label for="category_id" class="block text-gray-700 font-bold mb-2">Category</label>
            <select name="category_id" id="category_id" class="shadow border rounded-lg w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @if($book->category_id == $category->id) selected @endif>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline">
                Update Book
            </button>
        </div>
    </form>
</div>
@endsection