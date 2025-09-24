    @extends('layouts.admin')

    @section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-6">Categories</h1>

        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-4">
            <input type="text" id="search-input" placeholder="Search categories..." class="shadow border rounded w-full py-2 px-3" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Table -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="p-4 bg-gray-100 font-semibold">Category Table</div>
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="py-2 px-4 border-b">No</th>
                            <th class="py-2 px-4 border-b">Name</th>
                            <th class="py-2 px-4 border-b">Description</th>
                        </tr>
                    </thead>
                    <tbody id="category-table-body">
                        @include('admin.categories._table')
                    </tbody>
                </table>
                <div class="mt-4" id="pagination-links">
            {{ $categories->links() }}
        </div>
            </div>

            <!-- Create Form -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <div class="p-4 bg-gray-100 font-semibold mb-4">Create Category</div>
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block font-bold mb-2">Name</label>
                        <input type="text" name="name" id="name" class="shadow border rounded w-full py-2 px-3">
                    </div>
                    <div class="mb-4">
                        <label for="description" class="block font-bold mb-2">Description</label>
                        <textarea name="description" id="description" rows="4" class="shadow border rounded w-full py-2 px-3"></textarea>
                    </div>
                    <button type="submit" class="bg-black text-white py-2 px-4 rounded">Create</button>
                </form>
            </div>
        </div>

        
    </div>

    <!-- Include Modal -->
    @include('components.admin.edit-category-modal')
    @endsection

    @push('scripts')
    <script>
    let currentCategoryId;
    const modal = document.getElementById('edit-modal');
    const updateForm = document.getElementById('update-form');
    const deleteForm = document.getElementById('delete-form');
    const categoryTableBody = document.getElementById('category-table-body');
    const paginationLinks = document.getElementById('pagination-links');

    function closeModal() {
        modal.classList.add('hidden');
    }

    async function openModal(categoryId) {
        currentCategoryId = categoryId;
        try {
            const response = await fetch(`/admin/categories/${categoryId}/json`);
            if (!response.ok) throw new Error('HTTP error ' + response.status);
            const category = await response.json();

            document.getElementById('edit-name').value = category.name;
            document.getElementById('edit-description').value = category.description;

            updateForm.action = `/admin/categories/${categoryId}`;
            deleteForm.action = `/admin/categories/${categoryId}`;

            modal.classList.remove('hidden');
        } catch (error) {
            console.error('Error fetching category data:', error);
        }
    }

    function fetchAndRenderCategories(url) {
        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            categoryTableBody.innerHTML = data.html;
            paginationLinks.innerHTML = data.links;
            attachModalEventListeners();
        })
        .catch(error => {
            console.error('Error fetching categories:', error);
        });
    }

    function attachModalEventListeners() {
        document.querySelectorAll('tr[data-category-id]').forEach(row => {
            row.addEventListener('click', () => openModal(row.dataset.categoryId));
        });
    }

    paginationLinks.addEventListener('click', function(e) {
        if (e.target.tagName === 'A') {
            e.preventDefault();
            const url = e.target.href;
            fetchAndRenderCategories(url);
        }
    });

    document.getElementById('search-input').addEventListener('input', function() {
        const query = this.value;
        const url = `{{ route('admin.categories.index') }}?search=${encodeURIComponent(query)}`;
        fetchAndRenderCategories(url);
    });

    document.addEventListener('DOMContentLoaded', function() {
        attachModalEventListeners();
    });
    </script>
    @endpush
