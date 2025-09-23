<tbody>
    @forelse ($borrowings as $borrowing)
        <tr class="hover:bg-gray-50">
            <td class="py-2 px-4 border-b text-sm text-gray-600">{{ $borrowing->id }}</td>
            <td class="py-2 px-4 border-b text-sm text-gray-600">{{ $borrowing->user->name }}</td>
            <td class="py-2 px-4 border-b text-sm text-gray-600">{{ $borrowing->book->title }}</td>
            <td class="py-2 px-4 border-b text-sm text-gray-600">{{ $borrowing->borrowed_at->format('d M Y') }}</td>
            <td class="py-2 px-4 border-b text-sm text-gray-600">
                @if ($borrowing->returned_at)
                    {{ $borrowing->returned_at->format('d M Y') }}
                @else
                    -
                @endif
            </td>
            <td class="py-2 px-4 border-b text-sm">
                @if ($borrowing->returned_at)
                    <span class="bg-green-200 text-green-800 px-2 py-1 rounded-full text-xs">Returned</span>
                @else
                    <span class="bg-yellow-200 text-yellow-800 px-2 py-1 rounded-full text-xs">Borrowed</span>
                @endif
            </td>
            <td class="py-2 px-4 border-b text-sm">
                <button class="details-btn text-blue-600 hover:underline mr-2" data-id="{{ $borrowing->id }}">Details</button>
                @if (!$borrowing->returned_at)
                    <form action="{{ route('admin.borrowings.update', $borrowing->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to return this book?');" class="inline-block">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="text-indigo-600 hover:text-indigo-900 font-semibold">Confirm Return</button>
                    </form>
                @else
                    <span class="text-gray-400">N/A</span>
                @endif
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7" class="py-4 text-center text-gray-500">No borrowing records found.</td>
        </tr>
    @endforelse
</tbody>
