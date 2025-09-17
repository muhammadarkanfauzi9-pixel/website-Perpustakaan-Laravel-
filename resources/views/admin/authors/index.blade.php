@extends('layouts.admin')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-6">Author</h1>

        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif
        
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
                    <tbody>
                        @foreach ($authors as $index => $author)
                           <tr id="author-{{ $author->id }}" class="open-modal-btn cursor-pointer hover:bg-gray-100 transition-colors duration-200">
    <td class="py-2 px-4 border-b">{{ $index + 1 }}</td>
    <td class="py-2 px-4 border-b">{{ $author->name }}</td>
    <td class="py-2 px-4 border-b">{{ $author->description }}</td>
</tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

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
                    <button type="submit" class="bg-black hover:bg-blue-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-300 text-white font-bold py-2 px-4 rounded-lg">Create</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Memanggil komponen pop-up modal --}}
    @include('components.admin.edit-author-modal')
@endsection

@push('scripts')
<script>
    const modal = document.getElementById('edit-modal');
    const updateForm = document.getElementById('update-form');
    const deleteForm = document.getElementById('delete-form');
    let currentAuthorId;

    async function openModal(authorId) {
        currentAuthorId = authorId;
        try {
            const response = await fetch(`/admin/authors/${authorId}/json`);
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

            const author = await response.json();

            document.getElementById('edit-name').value = author.name;
            document.getElementById('edit-description').value = author.description;

            // set action update & delete form
            updateForm.action = `/admin/authors/${authorId}`;
            deleteForm.action = `/admin/authors/${authorId}`;

            modal.classList.remove('hidden');
            modal.classList.add('flex'); // biar tampil di tengah
        } catch (error) {
            console.error('Error fetching author data:', error);
            alert('Failed to load author data. Check console for details.');
        }
    }

    function closeModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.open-modal-btn').forEach(button => {
            button.addEventListener('click', function() {
                const authorId = this.id.split('-')[1];
                openModal(authorId);
            });
        });
    });
</script>
@endpush
