<tbody>
    @forelse ($publishers as $index => $publisher)
    <tr id="publisher-{{ $publisher->id }}" class="open-modal-btn cursor-pointer hover:bg-gray-100 transition-colors duration-200">
        <td class="py-2 px-4 border-b">{{ $publishers->firstItem() + $loop->index }}</td>
        <td class="py-2 px-4 border-b">{{ $publisher->name }}</td>
        <td class="py-2 px-4 border-b">{{ $publisher->address ?? '-' }}</td>
        <td class="py-2 px-4 border-b">{{ $publisher->phone ?? '-' }}</td>
    </tr>
    @empty
    <tr>
        <td colspan="4" class="py-4 text-center text-gray-500">No publishers found.</td>
    </tr>
    @endforelse
</tbody>

