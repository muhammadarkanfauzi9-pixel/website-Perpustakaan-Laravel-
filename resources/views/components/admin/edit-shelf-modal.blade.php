<!-- Edit Shelf Modal -->
<div id="edit-shelf-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Edit Shelf</h3>
            <form id="update-shelf-form" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="edit-name" class="block text-gray-700 font-bold mb-2">Shelf Name</label>
                    <input type="text" id="edit-name" name="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="closeShelfModal()" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Update</button>
                </div>
            </form>
            <form id="delete-shelf-form" method="POST" class="mt-4">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600" onclick="return confirm('Are you sure you want to delete this shelf?')">Delete Shelf</button>
            </form>
        </div>
    </div>
</div>

<script>
function closeShelfModal() {
    document.getElementById('edit-shelf-modal').classList.add('hidden');
    document.getElementById('edit-shelf-modal').classList.remove('flex');
}
</script>
