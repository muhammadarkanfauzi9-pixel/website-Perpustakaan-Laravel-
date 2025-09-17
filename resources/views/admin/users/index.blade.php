@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6">User Management</h1>

    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-200">
                <tr>
                    <th class="py-2 px-4 border-b text-left text-gray-700">ID</th>
                    <th class="py-2 px-4 border-b text-left text-gray-700">Name</th>
                    <th class="py-2 px-4 border-b text-left text-gray-700">Email</th>
                    <th class="py-2 px-4 border-b text-left text-gray-700">Role</th>
                    <th class="py-2 px-4 border-b text-left text-gray-700">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                <tr class="hover:bg-gray-50">
                    <td class="py-2 px-4 border-b text-sm text-gray-600">{{ $user->id }}</td>
                    <td class="py-2 px-4 border-b text-sm text-gray-600">{{ $user->name }}</td>
                    <td class="py-2 px-4 border-b text-sm text-gray-600">{{ $user->email }}</td>
                    <td class="py-2 px-4 border-b text-sm text-gray-600">{{ $user->role }}</td>
                    <td class="py-2 px-4 border-b text-sm">
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 font-semibold">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-4 text-center text-gray-500">No users found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection