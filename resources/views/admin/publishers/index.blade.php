@extends('layouts.admin')

@section('title', 'Publishers')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Publishers</h1>

    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Search Input -->
    <div class="mb-4">
        <input type="text" id="search-input" placeholder="Search publishers..." class="shadow border rounded w-full py-2 px-3">
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="p-4 bg-gray-100 font-semibold">Publisher Table</div>
            <table class="min-w-full bg-white">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-2 px-4 border-b text-left">No</th>
                        <th class="py-2 px-4 border-b text-left">Name</th>
                        <th class="py-2 px-4 border-b text-left">Address</th>
                        <th class="py-2 px-4 border-b text-left">Phone</th>
                    </tr>
                </thead>
                <tbody id="publisher-table-body">
                    {{-- Ini akan diisi oleh konten dari _table.blade.php --}}
                    @include('admin.publishers._table', ['publishers' => $publishers])
                </tbody>
            </table>

            {{-- Navigasi Pagination --}}
            <div id="pagination-links" class="p-4 flex justify-center">
                {{-- Remove default Laravel pagination links to avoid duplication --}}
                {{-- AJAX pagination handled in script --}}
            </div>
        </div>

        {{-- Form Tambah Publisher --}}
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="p-4 bg-gray-100 font-semibold mb-4">Create Publisher Form</div>
            <form action="{{ route('admin.publishers.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-bold mb-2">Publisher Name</label>
                    <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                </div>
                <div class="mb-4">
                    <label for="address" class="block text-gray-700 font-bold mb-2">Address</label>
                    <input type="text" name="address" id="address" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                </div>
                <div class="mb-4">
                    <label for="phone" class="block text-gray-700 font-bold mb-2">Phone</label>
                    <input type="text" name="phone" id="phone" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                </div>
                <button type="submit" class="bg-blue-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Create</button>
            </form>
        </div>
    </div>
</div>

{{-- Memanggil komponen pop-up modal (edit & delete) --}}
@include('components.admin.edit-publishers-modal')
@endsection

@push('scripts')
    <script>
        const modal = document.getElementById('edit-publisher-modal');
        const updateForm = document.getElementById('update-form');
        const deleteForm = document.getElementById('delete-form');
        
        const editNameInput = document.getElementById('edit-name');
        const editAddressInput = document.getElementById('edit-address');
        const editPhoneInput = document.getElementById('edit-phone');

        async function openModal(publisherId) {
            try {
                const response = await fetch(`/admin/publishers/${publisherId}/json`);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const publisher = await response.json();

                editNameInput.value = publisher.name;
                editAddressInput.value = publisher.address || '';
                editPhoneInput.value = publisher.phone || '';

                if (updateForm) {
                    updateForm.action = `/admin/publishers/${publisherId}`;
                }
                if (deleteForm) {
                    deleteForm.action = `/admin/publishers/${publisherId}`;
                }

                modal.classList.remove('hidden');
                modal.classList.add('flex');
            } catch (error) {
                console.error('Error fetching publisher data:', error);
                alert('Failed to load publisher data. Check console for details.');
            }
        }

        function closeModal() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Kode AJAX Pagination and Search
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search-input');
            const tableBody = document.getElementById('publisher-table-body');
            const paginationLinks = document.getElementById('pagination-links');

            // Event listener untuk klik pada baris tabel (untuk modal)
            function addModalListeners() {
                document.querySelectorAll('tr[id^="publisher-"]').forEach(row => {
                    row.addEventListener('click', function() {
                        const publisherId = this.id.split('-')[1];
                        openModal(publisherId);
                    });
                });
            }
            addModalListeners();

            // Function to fetch and render publishers
            function fetchAndRenderPublishers(url) {
                const searchQuery = searchInput.value;
                const params = new URLSearchParams();
                if (searchQuery) params.append('publisher_name', searchQuery);

                const fullUrl = url ? `${url.split('?')[0]}?${params.toString()}` : `?${params.toString()}`;

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
                    addModalListeners(); // Tambahkan lagi event listener setelah tabel diperbarui
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    alert('Failed to load data. Please check the console.');
                });
            }

            // Search input event
            searchInput.addEventListener('input', function() {
                fetchAndRenderPublishers(window.location.pathname);
            });

            // Event listener untuk klik pada tombol pagination
            paginationLinks.addEventListener('click', function(e) {
                if (e.target.tagName === 'A') {
                    e.preventDefault();
                    const url = e.target.href;
                    fetchAndRenderPublishers(url);
                }
            });
        });
    </script>
@endpush