 <!-- Edit User Modal -->
<div id="edit-user-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Edit User</h3>
            <form id="update-user-form" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="edit-name" class="block text-gray-700 font-bold mb-2">Name</label>
                    <input type="text" id="edit-name" name="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                </div>
                <div class="mb-4">
                    <label for="edit-email" class="block text-gray-700 font-bold mb-2">Email</label>
                    <input type="email" id="edit-email" name="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                </div>
                <div class="mb-4">
                    <label for="edit-role" class="block text-gray-700 font-bold mb-2">Role</label>
                    <select id="edit-role" name="role" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeUserModal()" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Cancel</button>
                    <button type="button" id="delete-user-btn"
                        class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600" onclick="deleteUser(currentUserId)">Delete</button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete User Form (Hidden) -->
<form id="delete-user-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
let currentUserId;
const authUserId = {{ auth()->id() }};

function openUserModal(userId) {
    currentUserId = userId;
    fetch(`/admin/users/${userId}/json`)
        .then(response => response.json())
        .then(user => {
            document.getElementById('edit-name').value = user.name;
            document.getElementById('edit-email').value = user.email;
            document.getElementById('edit-role').value = user.role;

            const updateForm = document.getElementById('update-user-form');
            const deleteForm = document.getElementById('delete-user-form');

            updateForm.action = `/admin/users/${userId}`;
            deleteForm.action = `/admin/users/${userId}`;

            // Always show delete button in the modal
            const deleteBtn = document.getElementById('delete-user-btn');
            deleteBtn.style.display = 'inline-block';

            document.getElementById('edit-user-modal').classList.remove('hidden');
            document.getElementById('edit-user-modal').classList.add('flex');
        })
        .catch(error => {
            console.error('Error fetching user data:', error);
        });
}

function closeUserModal() {
    document.getElementById('edit-user-modal').classList.add('hidden');
    document.getElementById('edit-user-modal').classList.remove('flex');
}

// Close modal when clicking outside
document.getElementById('edit-user-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeUserModal();
    }
});
</script>
