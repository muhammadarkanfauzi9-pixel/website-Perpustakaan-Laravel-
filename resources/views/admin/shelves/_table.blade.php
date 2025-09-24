<tbody>
    @forelse ($shelves as $index => $shelf)
        <tr class="hover:bg-gray-50 open-modal-btn cursor-pointer" data-id="{{ $shelf->id }}">
            <td class="py-2 px-4 border-b text-sm text-gray-600">{{ $shelves->firstItem() + $index }}</td>
            <td class="py-2 px-4 border-b text-sm text-gray-600">{{ $shelf->name }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="2" class="py-4 text-center text-gray-500">No shelves found.</td>
        </tr>
    @endforelse
</tbody>
