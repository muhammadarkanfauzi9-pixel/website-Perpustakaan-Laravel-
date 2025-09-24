@extends('layouts.admin')

@section('title', 'Add New Book')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Add New Book</h1>

    <div class="bg-white shadow-md rounded-lg p-6">
        <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="title" class="block text-gray-700 font-bold mb-2">Title</label>
                <input type="text" name="title" id="title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
            </div>

            <div class="mb-4">
                <label for="author_id" class="block text-gray-700 font-bold mb-2">Pilih Author</label>
                <select name="author_id" id="author_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                    <option value="">-- Pilih dari daftar --</option>
                    @foreach ($authors as $author)
                        <option value="{{ $author->id }}">{{ $author->name }}</option>
                    @endforeach
                </select>
                {{-- Bagian 'Atau Tambah Author Baru' telah dihapus --}}
            </div>

            <div class="mb-4">
                <label for="category_id" class="block text-gray-700 font-bold mb-2">Pilih Kategori</label>
                <select name="category_id" id="category_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                    <option value="">-- Pilih dari daftar --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="publisher_id" class="block text-gray-700 font-bold mb-2">Pilih Publisher</label>
                <select name="publisher_id" id="publisher_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                    <option value="">-- Pilih dari daftar --</option>
                    @foreach ($publishers as $publisher)
                        <option value="{{ $publisher->id }}">{{ $publisher->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="shelf_id" class="block text-gray-700 font-bold mb-2">Pilih Shelf</label>
                <select name="shelf_id" id="shelf_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                    <option value="">-- Pilih dari daftar --</option>
                    @foreach ($shelves as $shelf)
                        <option value="{{ $shelf->id }}">{{ $shelf->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="year" class="block text-gray-700 font-bold mb-2">Year</label>
                <input type="number" name="year" id="year" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" min="1900" max="{{ date('Y') }}">
            </div>

            <div class="mb-6">
                <label for="book_img" class="block text-gray-700 font-bold mb-2">Book Image</label>
                <input type="file" name="book_img" id="book_img" class="w-full text-gray-700">
            </div>
            
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline">
                    Save Book
                </button>
            </div>
        </form>
    </div>
</div>
@endsection