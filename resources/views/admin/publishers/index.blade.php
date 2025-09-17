@extends('layouts.admin')

@section('title', 'Publishers')

@section('content')
<div class="bg-white p-6 rounded shadow">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-semibold">Publishers</h1>
        <button onclick="openModal('add')" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            + Add Publisher
        </button>
    </div>

    {{-- Table --}}
    <table class="w-full border text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-4 py-2">#</th>
                <th class="border px-4 py-2">Name</th>
                <th class="border px-4 py-2">Address</th>
                <th class="border px-4 py-2">Phone</th>
                <th class="border px-4 py-2">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($publishers as $publisher)
            <tr>
                <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                <td class="border px-4 py-2">{{ $publisher->name }}</td>
                <td class="border px-4 py-2">{{ $publisher->address ?? '-' }}</td>
                <td class="border px-4 py-2">{{ $publisher->phone ?? '-' }}</td>
                <td class="border px-4 py-2 flex gap-2">
                    {{-- Tombol Edit --}}
                    <button 
                        onclick="openModal('edit', {{ $publisher->id }}, '{{ $publisher->name }}', '{{ $publisher->address }}', '{{ $publisher->phone }}')" 
                        class="text-blue-600 hover:underline">
                        Edit
                    </button>

                    {{-- Tombol Delete --}}
                    <form action="{{ route('admin.publishers.destroy', $publisher->id) }}" method="POST"
                        onsubmit="return confirm('Yakin hapus?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600 hover:underline">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Modal (Add & Edit pakai 1 modal) --}}
<div id="publisherModal"
    class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white p-6 rounded shadow-md w-full max-w-md">
        <h2 id="modalTitle" class="text-lg font-semibold mb-4">Add Publisher</h2>
        <form id="publisherForm" method="POST">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">

            <div class="mb-3">
                <label class="block text-sm font-medium">Name</label>
                <input type="text" name="name" id="publisherName" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium">Address</label>
                <input type="text" name="address" id="publisherAddress" class="w-full border rounded px-3 py-2">
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium">Phone</label>
                <input type="text" name="phone" id="publisherPhone" class="w-full border rounded px-3 py-2">
            </div>
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-200 rounded">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openModal(type, id = null, name = '', address = '', phone = '') {
        const modal = document.getElementById('publisherModal');
        const title = document.getElementById('modalTitle');
        const form = document.getElementById('publisherForm');
        const method = document.getElementById('formMethod');

        // Reset form
        form.reset();

        if (type === 'add') {
            title.innerText = "Add Publisher";
            form.action = "{{ route('admin.publishers.store') }}";
            method.value = "POST";
        } else if (type === 'edit') {
            title.innerText = "Edit Publisher";
            form.action = "/admin/publishers/" + id;
            method.value = "PUT";

            document.getElementById('publisherName').value = name;
            document.getElementById('publisherAddress').value = address;
            document.getElementById('publisherPhone').value = phone;
        }

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModal() {
        const modal = document.getElementById('publisherModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
@endpush
