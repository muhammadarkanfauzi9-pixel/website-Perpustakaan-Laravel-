@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6">All Book Borrowings</h1>

    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-4">
        <input type="text" id="search-input" placeholder="Search borrowings by user or book..." class="shadow border rounded w-full py-2 px-3" />
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-200">
                <tr>
                    <th class="py-2 px-4 border-b text-left text-gray-700">No</th>
                    <th class="py-2 px-4 border-b text-left text-gray-700">User</th>
                    <th class="py-2 px-4 border-b text-left text-gray-700">Book Title</th>
                    <th class="py-2 px-4 border-b text-left text-gray-700">Borrowed At</th>
                    <th class="py-2 px-4 border-b text-left text-gray-700">Returned At</th>
                    <th class="py-2 px-4 border-b text-left text-gray-700">Status</th>
                    <th class="py-2 px-4 border-b text-left text-gray-700">Actions</th>
                </tr>
            </thead>
            <tbody id="borrowing-table-body">
                @include('admin.borrowings._table', ['borrowings' => $borrowings])
            </tbody>
        </table>
    </div>
    <div class="mt-4" id="pagination-links">
        {{ $borrowings->links() }}
    </div>
</div>

<!-- Borrowing Details Modal with AJAX -->
<div id="borrowing-details-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-1/2 max-h-[80vh] overflow-y-auto">
        <h2 class="text-xl font-bold mb-4">Borrowing Details</h2>
        <div id="borrowing-details-content">
            Loading...
        </div>
        <button id="close-modal-btn" class="mt-4 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Close</button>
    </div>
</div>
@endsection

@push('scripts')
<script>
const borrowingTableBody = document.getElementById('borrowing-table-body');
const paginationLinks = document.getElementById('pagination-links');
const searchInput = document.getElementById('search-input');
const borrowingDetailsModal = document.getElementById('borrowing-details-modal');
const borrowingDetailsContent = document.getElementById('borrowing-details-content');
const closeModalBtn = document.getElementById('close-modal-btn');

function fetchAndRenderBorrowings(url) {
    const searchQuery = searchInput.value;
    const separator = url.includes('?') ? '&' : '?';
    const fullUrl = `${url}${separator}search=${encodeURIComponent(searchQuery)}`;

    fetch(fullUrl, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        borrowingTableBody.innerHTML = data.html;
        paginationLinks.innerHTML = data.links;
        attachDetailsEventListeners();
    })
    .catch(error => {
        console.error('Error fetching borrowings:', error);
    });
}

paginationLinks.addEventListener('click', function(e) {
    if (e.target.tagName === 'A') {
        e.preventDefault();
        const url = e.target.href;
        fetchAndRenderBorrowings(url);
    }
});

searchInput.addEventListener('input', function() {
    const url = `{{ route('admin.borrowings.index') }}`;
    fetchAndRenderBorrowings(url);
});

function attachDetailsEventListeners() {
    document.querySelectorAll('.details-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const borrowingId = this.dataset.id;
            fetchBorrowingDetails(borrowingId);
        });
    });
}

function fetchBorrowingDetails(borrowingId) {
    borrowingDetailsContent.innerHTML = 'Loading...';
    borrowingDetailsModal.classList.remove('hidden');

    fetch(`/admin/borrowings/${borrowingId}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            if (response.status === 401 || response.status === 403) {
                borrowingDetailsContent.innerHTML = 'You are not authorized to view this content. Please log in as an admin.';
                return;
            }
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const contentType = response.headers.get('content-type');
        if (contentType && contentType.includes('application/json')) {
            return response.json();
        } else {
            // If not JSON, assume HTML redirect or error page
            borrowingDetailsContent.innerHTML = 'Authentication required. Please refresh the page and log in.';
            return;
        }
    })
    .then(data => {
        if (!data) return; // Already handled above
        // Format the data into HTML
        const html = `
            <div class="space-y-4">
                <div><strong>User:</strong> ${data.user.name} (${data.user.email})</div>
                <div><strong>Book:</strong> ${data.book.title}</div>
                <div><strong>Borrowed At:</strong> ${data.borrowed_at}</div>
                <div><strong>Returned At:</strong> ${data.returned_at || 'Not returned yet'}</div>
                <div><strong>Status:</strong> ${data.returned_at ? 'Returned' : 'Borrowed'}</div>
            </div>
        `;
        borrowingDetailsContent.innerHTML = html;
    })
    .catch(error => {
        borrowingDetailsContent.innerHTML = 'Failed to load details. Please check your connection and try again.';
        console.error('Error fetching borrowing details:', error);
    });
}

closeModalBtn.addEventListener('click', function() {
    borrowingDetailsModal.classList.add('hidden');
    borrowingDetailsContent.innerHTML = '';
});

// Initialize details buttons on page load
attachDetailsEventListeners();
</script>
@endpush
