@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6">Books</h1>

    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-end mb-4">
        <a href="{{ route('admin.books.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Add Book
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-200">
                <tr>
                    <th class="py-2 px-4 border-b text-left text-gray-700">ID</th>
                    <th class="py-2 px-4 border-b text-left text-gray-700">Title</th>
                    <th class="py-2 px-4 border-b text-left text-gray-700">Author</th>
                    <th class="py-2 px-4 border-b text-left text-gray-700">Publisher</th>
                    <th class="py-2 px-4 border-b text-left text-gray-700">Category</th>
                    <th class="py-2 px-4 border-b text-left text-gray-700">Shelf</th>
                    <th class="py-2 px-4 border-b text-left text-gray-700">Year</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($books as $book)
                    <tr id="book-{{ $book->id }}" class="open-modal-btn cursor-pointer hover:bg-gray-100 transition-colors duration-200">
                        <td class="py-2 px-4 border-b text-sm text-gray-600">{{ $book->id }}</td>
                        <td class="py-2 px-4 border-b text-sm text-gray-600">{{ $book->title }}</td>
                        <td class="py-2 px-4 border-b text-sm text-gray-600">{{ $book->author->name }}</td>
                        <td class="py-2 px-4 border-b text-sm text-gray-600">{{ $book->publisher->name }}</td>
                        <td class="py-2 px-4 border-b text-sm text-gray-600">{{ $book->category->name }}</td>
                        <td class="py-2 px-4 border-b text-sm text-gray-600">{{ $book->shelf->name }}</td>
                        <td class="py-2 px-4 border-b text-sm text-gray-600">{{ $book->year }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-4 text-center text-gray-500">No books found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @include('components.admin.edit-book-modal', [
        'authors' => $authors,
        'publishers' => $publishers,
        'categories' => $categories,
        'shelves' => $shelves
    ])
</div>
@endsection

@push('scripts')
<script>
    const modal = document.getElementById('edit-book-modal');
    const updateForm = document.getElementById('update-book-form');
    const deleteForm = document.getElementById('delete-book-form');

    async function openModal(bookId) {
        try {
            // Gunakan rute `show` dari resource
            const response = await fetch(`/admin/books/${bookId}`);
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            
            const book = await response.json();
            
            document.getElementById('edit-title').value = book.title;
            document.getElementById('edit-year').value = book.year;

            document.getElementById('edit-author-id').value = book.author_id;
            document.getElementById('edit-publisher-id').value = book.publisher_id;
            document.getElementById('edit-category-id').value = book.category_id;
            document.getElementById('edit-shelf-id').value = book.shelf_id;
            
            // Set action update & delete form
            updateForm.action = `/admin/books/${bookId}`;
            deleteForm.action = `/admin/books/${bookId}`;

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        } catch (error) {
            console.error('Error fetching book data:', error);
            alert('Failed to load book data. Check console for details.');
        }
    }

    function closeModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.open-modal-btn').forEach(button => {
            button.addEventListener('click', function() {
                const bookId = this.id.split('-')[1];
                openModal(bookId);
            });
        });

        const closeBtn = document.getElementById('close-modal-btn');
        if(closeBtn) {
            closeBtn.addEventListener('click', closeModal);
        }
    });
</script>
@endpush