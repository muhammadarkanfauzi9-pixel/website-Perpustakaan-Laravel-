@extends('layouts.admin')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-6">Add New Book</h1>
        <form action="{{ route('admin.books.store') }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
            @csrf
            <div class="mb-4">
                <label for="title" class="block text-gray-700 font-bold mb-2">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
            </div>
            <div class="mb-4">
                <label for="author" class="block text-gray-700 font-bold mb-2">Author</label>
                <input type="text" name="author" id="author" value="{{ old('author') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
            </div>
            <div class="mb-4">
                <label for="book_img" class="block text-gray-700 font-bold mb-2">Book Image</label>
                <input type="file" name="book_img" id="book_img" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" accept="image/*">
            </div>
            <div class="mb-4">
                <label for="publisher_id" class="block text-gray-700 font-bold mb-2">Publisher</label>
                <select name="publisher_id" id="publisher_id" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                    @foreach($publishers as $publisher)
                        <option value="{{ $publisher->id }}">{{ $publisher->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="shelf_id" class="block text-gray-700 font-bold mb-2">Shelf</label>
                <select name="shelf_id" id="shelf_id" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                    @foreach($shelves as $shelf)
                        <option value="{{ $shelf->id }}">{{ $shelf->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="category_id" class="block text-gray-700 font-bold mb-2">Category</label>
                <select name="category_id" id="category_id" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded-lg">Add Book</button>
        </form>
    </div>
@endsection