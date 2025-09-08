@extends('layouts.admin')

@section('content')
    <div class="container mx-auto p-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Manage Books</h1>
            <a href="{{ route('admin.books.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Add Book</a>
        </div>

        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-2 px-4 border-b text-left">ID</th>
                        <th class="py-2 px-4 border-b text-left">Title</th>
                        <th class="py-2 px-4 border-b text-left">Author</th>
                        <th class="py-2 px-4 border-b text-left">Publisher</th>
                        <th class="py-2 px-4 border-b text-left">Category</th>
                        <th class="py-2 px-4 border-b text-left">Shelf</th>
                        <th class="py-2 px-4 border-b text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($books as $book)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $book->id }}</td>
                            <td class="py-2 px-4 border-b">{{ $book->title }}</td>
                            <td class="py-2 px-4 border-b">{{ $book->author }}</td>
                            <td class="py-2 px-4 border-b">{{ $book->publisher->name }}</td>
                            <td class="py-2 px-4 border-b">{{ $book->category->name }}</td>
                            <td class="py-2 px-4 border-b">{{ $book->shelf->name }}</td>
                            <td class="py-2 px-4 border-b flex space-x-2">
                                <a href="{{ route('admin.books.edit', $book) }}" class="bg-yellow-500 text-white px-3 py-1 rounded-md">Edit</a>
                                <form action="{{ route('admin.books.destroy', $book) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded-md">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $books->links() }}
        </div>
    </div>
@endsection