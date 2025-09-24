    @forelse ($books as $index => $book)
        <tr class="cursor-pointer hover:bg-gray-50 open-modal-btn" id="book-{{ $book->id }}">
            <td>{{ $books->firstItem() + $index }}</td>
            <td>{{ $book->title }}</td>
            <td>{{ $book->author->name ?? '' }}</td>
            <td>{{ $book->publisher->name ?? '' }}</td>
            <td>{{ $book->category->name ?? '' }}</td>
            <td>{{ $book->shelf->name ?? '' }}</td>
            <td>{{ $book->year }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="7" class="py-4 text-center text-gray-500">No books found.</td>
        </tr>
    @endforelse
