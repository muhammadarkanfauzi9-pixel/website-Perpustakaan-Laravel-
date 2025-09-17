@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6">Users</h1>

    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-500 text-white p-4 rounded-lg mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Table Users -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="p-4 bg-gray-100 font-semibold">User Table</div>
            <table class="min-w-full bg-white">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-2 px-4 border-b">No</th>
                        <th class="py-2 px-4 border-b">Name</th>
                        <th class="py-2 px-4 border-b">Email</th>
                        <th class="py-2 px-4 border-b">Role</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $index => $user)
                        <tr class="border-b cursor-pointer hover:bg-gray-100" 
                            data-user-id="{{ $user->id }}">
                            <td class="py-2 px-4">{{ $users->firstItem() + $index }}</td>
                            <td class="py-2 px-4">{{ $user->name }}</td>
                            <td class="py-2 px-4">{{ $user->email }}</td>
                            <td class="py-2 px-4 capitalize">{{ $user->role }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>

        <!-- Form Create User/Admin -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="p-4 bg-gray-100 font-semibold mb-4">Add New User/Admin</div>
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block font-bold mb-2">Name</label>
                    <input type="text" name="name" id="name" class="shadow border rounded w-full py-2 px-3" required>
                </div>
                <div class="mb-4">
                    <label for="email" class="block font-bold mb-2">Email</label>
                    <input type="email" name="email" id="email" class="shadow border rounded w-full py-2 px-3" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="block font-bold mb-2">Password</label>
                    <input type="password" name="password" id="password" class="shadow border rounded w-full py-2 px-3" required>
                </div>
                <div class="mb-4">
                    <label for="password_confirmation" class="block font-bold mb-2">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="shadow border rounded w-full py-2 px-3" required>
                </div>
                <div class="mb-4">
                    <label for="role" class="block font-bold mb-2">Role</label>
                    <select name="role" id="role" class="shadow border rounded w-full py-2 px-3" required>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <button type="submit" class="bg-black text-white py-2 px-4 rounded">Create</button>
            </form>
        </div>
    </div>
</div>

<!-- Edit/Delete Modal -->
<div id="edit-modal" class="fixed inset-0 bg-gray-800 bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg w-1/3">
        <div class="flex justify-between items-center border-b px-4 py-2">
            <h3 class="text-lg font-semibold">User Details</h3>
            <button onclick="closeModal()" class="text-gray-600 hover:text-gray-800">&times;</button>
        </div>
        <div class="p-4">
            <p><strong>Name:</strong> <span id="modal-name"></span></p>
            <p><strong>Email:</strong> <span id="modal-email"></span></p>
            <p><strong>Role:</strong> <span id="modal-role"></span></p>

            <div class="flex justify-end mt-4">
                <button id="delete-user-btn" class="bg-red-600 text-white px-4 py-2 rounded-lg">
                    Delete
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let currentUserId;
const modal = document.getElementById('edit-modal');

function closeModal() {
    modal.classList.add('hidden');
}

async function openModal(userId) {
    currentUserId = userId;
    try {
        const response = await fetch(`/admin/users/${userId}/json`);
        if (!response.ok) throw new Error('HTTP error ' + response.status);
        const user = await response.json();

        document.getElementById('modal-name').textContent = user.name;
        document.getElementById('modal-email').textContent = user.email;
        document.getElementById('modal-role').textContent = user.role;

        modal.classList.remove('hidden');
    } catch (error) {
        console.error('Error fetching user data:', error);
        alert('Failed to load user data.');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('tr[data-user-id]').forEach(row => {
        row.addEventListener('click', () => openModal(row.dataset.userId));
    });

    document.getElementById('delete-user-btn').addEventListener('click', async () => {
        if(!confirm('Yakin ingin menghapus user ini?')) return;
        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const response = await fetch(`/admin/users/${currentUserId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json'
                }
            });
            if(!response.ok) throw new Error('HTTP error ' + response.status);
            window.location.reload();
        } catch (error) {
            console.error('Error deleting user:', error);
            alert('Failed to delete user.');
        }
    });
});
</script>
@endpush
