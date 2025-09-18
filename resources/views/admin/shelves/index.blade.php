@extends('layouts.admin')

@section('content')
    <div class="container mx-auto p-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Manage Shelves</h1>
        </div>

        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-4">
            <input type="text" id="search-input" placeholder="Search shelves..." class="shadow border rounded w-full py-2 px-3" />
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-2 px-4 border-b text-left">ID</th>
                        <th class="py-2 px-4 border-b text-left">Name</th>
                    </tr>
                </thead>
                <tbody id="shelves-table-body">
                    @include('admin.shelves._table')
                </tbody>
            </table>
        </div>

        <div class="mt-4" id="pagination-links">
            {{ $shelves->links() }}
        </div>
    </div>

    @include('components.admin.edit-shelf-modal')
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const shelvesTableBody = document.getElementById('shelves-table-body');
    const paginationLinks = document.getElementById('pagination-links');
    const searchInput = document.getElementById('search-input');
    const modal = document.getElementById('edit-shelf-modal');
    const updateForm = document.getElementById('update-shelf-form');
    const deleteForm = document.getElementById('delete-shelf-form');

    function openModal(shelfId) {
        fetch(`/admin/shelves/${shelfId}/edit`)
            .then(response => response.json())
            .then(shelf => {
                document.getElementById('edit-name').value = shelf.name;
                updateForm.action = `/admin/shelves/${shelfId}`;
                deleteForm.action = `/admin/shelves/${shelfId}`;
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            })
            .catch(error => {
                console.error('Error fetching shelf data:', error);
                alert('Failed to load shelf data. Check console for details.');
            });
    }

    function closeModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function closeShelfModal() {
        closeModal();
    }

    function fetchAndRenderShelves(url) {
        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            shelvesTableBody.innerHTML = data.html;
            paginationLinks.innerHTML = data.links;
            attachModalListeners();
        })
        .catch(error => {
            console.error('Error fetching shelves:', error);
        });
    }

    function attachModalListeners() {
        document.querySelectorAll('.open-modal-btn').forEach(row => {
            row.addEventListener('click', function() {
                const shelfId = this.dataset.id;
                openModal(shelfId);
            });
        });
    }

    paginationLinks.addEventListener('click', function(e) {
        if (e.target.tagName === 'A') {
            e.preventDefault();
            const url = e.target.href;
            fetchAndRenderShelves(url);
        }
    });

    searchInput.addEventListener('input', function() {
        const query = this.value;
        const url = `{{ route('admin.shelves.index') }}?search=${encodeURIComponent(query)}`;
        fetchAndRenderShelves(url);
    });

    attachModalListeners();
});
</script>
@endpush
