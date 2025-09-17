@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6">Categories</h1>

    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

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
                <tbody>
                    @foreach ($categories as $index => $category)
                        <tr class="cursor-pointer hover:bg-gray-100" data-category-id="{{ $category->id }}">
                            <td class="py-2 px-4 border-b">{{ $categories->firstItem() + $index }}</td>
                            <td class="py-2 px-4 border-b">{{ $category->name }}</td>
                            <td class="py-2 px-4 border-b">{{ $category->description }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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

    <div class="mt-4">
        {{ $categories->links() }}
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

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('tr[data-category-id]').forEach(row => {
        row.addEventListener('click', () => openModal(row.dataset.categoryId));
    });
});


</script>
@endpush
