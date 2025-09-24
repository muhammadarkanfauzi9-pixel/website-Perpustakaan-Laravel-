<div id="edit-publisher-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white p-6 rounded shadow-md w-full max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold">Edit Publisher</h2>
            <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
        </div>
        
        <form id="update-form" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="edit-name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" id="edit-name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div class="mb-3">
                <label for="edit-address" class="block text-sm font-medium text-gray-700">Address</label>
                <input type="text" name="address" id="edit-address" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>
            <div class="mb-3">
                <label for="edit-phone" class="block text-sm font-medium text-gray-700">Phone</label>
                <input type="text" name="phone" id="edit-phone" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>
        </form>
        
        <div class="flex justify-end gap-2 mt-4">
            <form id="delete-form" action="" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">Delete</button>
            </form>
            <button type="submit" form="update-form" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">Update</button>
        </div>
    </div>
</div>