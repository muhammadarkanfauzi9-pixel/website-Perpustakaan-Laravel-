<!-- Edit Author Modal -->
<div id="edit-modal" class="fixed inset-0 bg-gray-800 bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg w-1/3">
        <div class="flex justify-between items-center border-b px-4 py-2">
            <h3 class="text-lg font-semibold">Update Author Form</h3>
            <button onclick="closeModal()" class="text-gray-600 hover:text-gray-800">&times;</button>
        </div>
        <div class="p-4">
            <!-- Update Form -->
            <form id="update-form" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="edit-name" class="block text-gray-700 font-bold mb-2">Name</label>
                    <input type="text" name="name" id="edit-name"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700"
                           autocomplete="name">
                </div>
                <div class="mb-4">
                    <label for="edit-description" class="block text-gray-700 font-bold mb-2">Description</label>
                    <textarea name="description" id="edit-description" rows="4"
                              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700"
                              autocomplete="off"></textarea>
                </div>
            </form>

            <!-- Tombol sejajar -->
            <div class="flex justify-between mt-4">
                <!-- Tombol Update -->
                <button type="submit" form="update-form"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                    Update
                </button>

                <!-- Delete Form -->
                <form action="" id="delete-form" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                @csrf
                @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg">
                    Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
