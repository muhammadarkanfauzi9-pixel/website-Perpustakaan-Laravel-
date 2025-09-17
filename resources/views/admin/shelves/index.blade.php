@extends('layouts.admin')

@section('content')
    <div class="container mx-auto p-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Manage Shelves</h1>
            <a href="{{ route('admin.shelves.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Add Shelf</a>
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
                        <th class="py-2 px-4 border-b text-left">Name</th>
                        <th class="py-2 px-4 border-b text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($shelves as $shelf)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $shelf->id }}</td>
                            <td class="py-2 px-4 border-b">{{ $shelf->name }}</td>
                            <td class="py-2 px-4 border-b flex space-x-2">
                                <a href="{{ route('admin.shelves.edit', $shelf) }}" 
                                   class="bg-yellow-500 text-white px-3 py-1 rounded-md">Edit</a>
                                <form action="{{ route('admin.shelves.destroy', $shelf) }}" method="POST" 
                                      onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="bg-red-500 text-white px-3 py-1 rounded-md">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-4 px-4 text-center text-gray-500">
                                No shelves found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $shelves->links() }}
        </div>
    </div>
@endsection
