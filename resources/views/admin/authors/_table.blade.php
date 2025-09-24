    @forelse ($authors as $index => $author)
    <tr id="author-{{ $author->id }}" class="open-modal-btn cursor-pointer hover:bg-gray-100 transition-colors duration-200">
        <td class="py-2 px-4 border-b">{{ $authors->firstItem() + $loop->index }}</td>
        <td class="py-2 px-4 border-b">{{ $author->name }}</td>
        <td class="py-2 px-4 border-b">{{ $author->description ?? '-' }}</td>
    </tr>
    @empty
    <tr>
        <td colspan="3" class="py-4 text-center text-gray-500">No authors found.</td>
    </tr>
    @endforelse
