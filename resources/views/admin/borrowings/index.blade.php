@extends('layouts.admin')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-6">All Book Borrowings</h1>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-2 px-4 border-b text-left">ID</th>
                        <th class="py-2 px-4 border-b text-left">User</th>
                        <th class="py-2 px-4 border-b text-left">Book Title</th>
                        <th class="py-2 px-4 border-b text-left">Borrowed At</th>
                        <th class="py-2 px-4 border-b text-left">Returned At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($borrowings as $borrowing)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $borrowing->id }}</td>
                            <td class="py-2 px-4 border-b">{{ $borrowing->user->name }}</td>
                            <td class="py-2 px-4 border-b">{{ $borrowing->book->title }}</td>
                            <td class="py-2 px-4 border-b">{{ $borrowing->borrowed_at }}</td>
                            <td class="py-2 px-4 border-b">
                                @if ($borrowing->returned_at)
                                    {{ $borrowing->returned_at }}
                                @else
                                    <span class="text-red-500">Not Returned</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $borrowings->links() }}
        </div>
    </div>
@endsection