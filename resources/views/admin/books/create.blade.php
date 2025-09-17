@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6">Add New Book</h1>

    @if ($errors->any())
        <div class="bg-red-500 text-white p-4 rounded-lg mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded-lg p-6">
        @csrf

        <div class="mb-4">
            <label for="title" class="block text-gray-700 font-bold mb-2">Title</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" required class="shadow border rounded w-full py-2 px-3">
        </div>

        {{-- Pilih Author yang sudah ada --}}
<div class="mb-4">
    <label for="author_id" class="block font-semibold mb-2">Pilih Author</label>
    <select name="author_id" id="author_id" class="w-full border rounded p-2">
        <option value="">-- Pilih dari daftar --</option>
        @foreach($authors as $author)
            <option value="{{ $author->id }}">{{ $author->name }}</option>
        @endforeach
    </select>
</div>

{{-- Atau masukkan author baru --}}
<div class="mb-4">
    <label for="author_name" class="block font-semibold mb-2">Atau Tambah Author Baru</label>
    <input type="text" name="author_name" id="author_name" placeholder="Nama author baru"
           class="w-full border rounded p-2">
</div>


        <div class="mb-4">
            <label for="year" class="block text-gray-700 font-bold mb-2">Year</label>
            <input type="number" name="year" id="year" value="{{ old('year') }}" required class="shadow border rounded w-full py-2 px-3" min="1900" max="{{ date('Y') }}">
        </div>

        <div class="mb-4">
            <label for="book_img" class="block text-gray-700 font-bold mb-2">Book Image</label>
            <input type="file" name="book_img" id="book_img" accept="image/*" class="shadow border rounded w-full py-2 px-3">
        </div>

        <div class="mb-4">
            <label for="publisher_id" class="block text-gray-700 font-bold mb-2">Publisher</label>
            <select name="publisher_id" id="publisher_id" class="shadow border rounded w-full py-2 px-3">
                @foreach($publishers as $publisher)
                    <option value="{{ $publisher->id }}">{{ $publisher->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="shelf_id" class="block text-gray-700 font-bold mb-2">Shelf</label>
            <select name="shelf_id" id="shelf_id" class="shadow border rounded w-full py-2 px-3">
                @foreach($shelves as $shelf)
                    <option value="{{ $shelf->id }}">{{ $shelf->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="category_id" class="block text-gray-700 font-bold mb-2">Category</label>
            <select name="category_id" id="category_id" class="shadow border rounded w-full py-2 px-3">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">Add Book</button>
    </form>
</div>
@endsection
