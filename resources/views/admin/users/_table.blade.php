<tbody>
    @forelse ($users as $user)
        <tr class="hover:bg-gray-50 open-modal-btn cursor-pointer" id="user-{{ $user->id }}">
            <td class="py-2 px-4 border-b text-sm text-gray-600">{{ $users->firstItem() + $loop->index }}</td>
            <td class="py-2 px-4 border-b text-sm text-gray-600">{{ $user->name }}</td>
            <td class="py-2 px-4 border-b text-sm text-gray-600">{{ $user->email }}</td>
            <td class="py-2 px-4 border-b text-sm text-gray-600">{{ $user->role }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="4" class="py-4 text-center text-gray-500">No users found.</td>
        </tr>
    @endforelse
</tbody>
