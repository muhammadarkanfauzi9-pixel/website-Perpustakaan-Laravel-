@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6">Books</h1>

    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-4">
        <input type="text" id="search-input" placeholder="Search books by title, author, or category..." class="shadow border rounded w-full py-2 px-3" />
    </div>

    <x-admin.table-wrapper :items="$books">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Publisher</th>
                    <th>Category</th>
                    <th>Shelf</th>
                    <th>Year</th>
                </tr>
            </thead>
            <tbody id="books-table-body">
                @include('admin.books._table')
            </tbody>
        </table>
    </x-admin.table-wrapper>

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
const booksTableBody = document.getElementById('books-table-body');
const paginationLinks = document.getElementById('pagination-links');
const modal = document.getElementById('edit-book-modal');
const updateForm = document.getElementById('update-book-form');
const deleteForm = document.getElementById('delete-book-form');

function fetchAndRenderBooks(url) {
    fetch(url, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        booksTableBody.innerHTML = data.html;
        paginationLinks.innerHTML = data.links;
        attachModalEventListeners();
    })
    .catch(error => {
        console.error('Error fetching books:', error);
    });
}

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

function attachModalEventListeners() {
    document.querySelectorAll('.open-modal-btn').forEach(button => {
        button.addEventListener('click', function() {
            const bookId = this.id.split('-')[1];
            openModal(bookId);
        });
    });
}

paginationLinks.addEventListener('click', function(e) {
    if (e.target.tagName === 'A') {
        e.preventDefault();
        const url = e.target.href;
        fetchAndRenderBooks(url);
    }
});

document.getElementById('search-input').addEventListener('input', function() {
    const query = this.value;
    const url = `{{ route('admin.books.index') }}?search=${encodeURIComponent(query)}`;
    fetchAndRenderBooks(url);
});

document.addEventListener('DOMContentLoaded', function() {
    attachModalEventListeners();

    const closeBtn = document.getElementById('close-modal-btn');
    if(closeBtn) {
        closeBtn.addEventListener('click', closeModal);
    }
});
</script>
@endpush
