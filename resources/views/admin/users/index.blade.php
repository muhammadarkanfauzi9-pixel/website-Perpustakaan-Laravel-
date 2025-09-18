@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6">User Management</h1>

    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Search Input -->
    <div class="mb-4">
        <input type="text" id="search-input" placeholder="Search users..." class="shadow border rounded w-full py-2 px-3">
    </div>

<div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-200">
                <tr>
                    <th class="py-2 px-4 border-b text-left text-gray-700">No</th>
                    <th class="py-2 px-4 border-b text-left text-gray-700">Name</th>
                    <th class="py-2 px-4 border-b text-left text-gray-700">Email</th>
                    <th class="py-2 px-4 border-b text-left text-gray-700">Role</th>
                </tr>
            </thead>
            <tbody id="user-table-body">
                @include('admin.users._table')
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <div class="mt-4" id="pagination-links">
        <div class="flex justify-between w-full max-w-md">
            @if ($users->onFirstPage())
                <span class="text-gray-400">Previous</span>
            @else
                <a href="{{ $users->previousPageUrl() }}" class="text-blue-600 hover:underline">Previous</a>
            @endif

            @if ($users->hasMorePages())
                <a href="{{ $users->nextPageUrl() }}" class="text-blue-600 hover:underline">Next</a>
            @else
                <span class="text-gray-400">Next</span>
            @endif
        </div>
    </div>
</div>

<!-- Include Modal -->
@include('components.admin.edit-user-modal')
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    const tableBody = document.getElementById('user-table-body');
    const paginationLinks = document.getElementById('pagination-links');

    // Function to fetch and render users
    function fetchAndRenderUsers(url) {
        const searchQuery = searchInput.value;
        const params = new URLSearchParams();
        if (searchQuery) params.append('search', searchQuery);

        // Fix URL to correctly append query parameters
        let fullUrl = url || window.location.pathname;
        if (fullUrl.indexOf('?') === -1) {
            fullUrl += '?' + params.toString();
        } else {
            fullUrl += '&' + params.toString();
        }

        fetch(fullUrl, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            tableBody.innerHTML = data.html;
            paginationLinks.innerHTML = data.links;
            attachModalEventListeners();
        })
        .catch(error => {
            console.error('Error fetching users:', error);
        });
    }

    function attachModalEventListeners() {
        document.querySelectorAll('.open-modal-btn').forEach(button => {
            button.addEventListener('click', function() {
                const userId = this.id.split('-')[1];
                openUserModal(userId);
            });
        });
    }

    // Search input event
    searchInput.addEventListener('input', function() {
        fetchAndRenderUsers(window.location.pathname);
    });

    // Pagination links event
    paginationLinks.addEventListener('click', function(e) {
        if (e.target.tagName === 'A') {
            e.preventDefault();
            const url = e.target.href;
            fetchAndRenderUsers(url);
        }
    });

    // Initialize modal event listeners on page load
    attachModalEventListeners();
});

function deleteUser(userId) {
    if (!confirm("Apakah kamu yakin ingin menghapus user ini?")) return;

    fetch(`/admin/users/${userId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => {
                throw new Error(err.error || "Gagal menghapus user");
            });
        }
        return response.json();
    })
    .then(data => {
        alert(data.message || "User berhasil dihapus!");
        location.reload();
    })
    .catch(error => {
        console.error("Error deleting user:", error);
        alert(error.message || "Terjadi kesalahan saat menghapus user.");
    });
}
</script>
@endpush

