@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Author</h1>

    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Search Input -->
    <div class="mb-4">
        <input type="text" id="search-input" placeholder="Search authors..." class="shadow border rounded w-full py-2 px-3">
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="p-4 bg-gray-100 font-semibold">Author Table</div>
            <table class="min-w-full bg-white">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-2 px-4 border-b text-left">No</th>
                        <th class="py-2 px-4 border-b text-left">Name</th>
                        <th class="py-2 px-4 border-b text-left">Description</th>
                    </tr>
                </thead>
                <tbody id="author-table-body">
                    {{-- Ini akan diisi oleh konten dari _table.blade.php --}}
                    @include('admin.authors._table', ['authors' => $authors])
                </tbody>
            </table>

            {{-- Navigasi Pagination --}}
            <div id="pagination-links" class="p-4 flex justify-center">
    {{ $authors->links('pagination::tailwind') }}
</div>

        </div>

        {{-- Form Tambah Author --}}
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="p-4 bg-gray-100 font-semibold mb-4">Create Author Form</div>
            <form action="{{ route('admin.authors.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-bold mb-2">Author Name</label>
                    <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-gray-700 font-bold mb-2">Author Description</label>
                    <textarea name="description" id="description" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700"></textarea>
                </div>
                <button type="submit" class="bg-blue-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Create</button>
            </form>
        </div>
    </div>
</div>

{{-- Memanggil komponen pop-up modal (edit & delete) --}}
@include('components.admin.edit-author-modal')
@endsection

@push('scripts')
    <script>
        const modal = document.getElementById('edit-modal');
        const updateForm = document.getElementById('update-form');
        const deleteForm = document.getElementById('delete-form');

        const editNameInput = document.getElementById('edit-name');
        const editDescriptionInput = document.getElementById('edit-description');

        async function openModal(authorId) {
            try {
                const response = await fetch(`/admin/authors/${authorId}/json`);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const author = await response.json();

                editNameInput.value = author.name;
                editDescriptionInput.value = author.description || '';

                if (updateForm) {
                    updateForm.action = `/admin/authors/${authorId}`;
                }
                if (deleteForm) {
                    deleteForm.action = `/admin/authors/${authorId}`;
                }

                modal.classList.remove('hidden');
                modal.classList.add('flex');
            } catch (error) {
                console.error('Error fetching author data:', error);
                alert('Failed to load author data. Check console for details.');
            }
        }

        function closeModal() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Kode AJAX Pagination and Search
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search-input');
            const tableBody = document.getElementById('author-table-body');
            const paginationLinks = document.getElementById('pagination-links');

            // Event listener untuk klik pada baris tabel (untuk modal)
            function addModalListeners() {
                document.querySelectorAll('tr[id^="author-"]').forEach(row => {
                    row.addEventListener('click', function() {
                        const authorId = this.id.split('-')[1];
                        openModal(authorId);
                    });
                });
            }
            addModalListeners();

            // Function to fetch and render authors
            function fetchAndRenderAuthors(url) {
    const searchQuery = searchInput.value;
    const params = new URLSearchParams();
    if (searchQuery) params.append('author_name', searchQuery);

    let fullUrl = url || window.location.pathname;
    if (params.toString()) {
        fullUrl += (fullUrl.includes('?') ? '&' : '?') + params.toString();
    }

    fetch(fullUrl, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        tableBody.innerHTML = data.html;
        paginationLinks.innerHTML = data.links;
        addModalListeners();
    })
    .catch(error => {
        console.error('Error fetching data:', error);
        alert('Failed to load data. Please check the console.');
    });
}


            // Search input event
            searchInput.addEventListener('input', function() {
                fetchAndRenderAuthors(window.location.pathname);
            });

            // Event listener untuk klik pada tombol pagination
            paginationLinks.addEventListener('click', function(e) {
                if (e.target.tagName === 'A') {
                    e.preventDefault();
                    const url = e.target.href;
                    fetchAndRenderAuthors(url);
                }
            });
        });
    </script>
@endpush
