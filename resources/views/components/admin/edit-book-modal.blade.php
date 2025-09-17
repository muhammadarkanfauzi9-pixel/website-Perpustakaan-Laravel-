{{-- resources/views/components/admin/edit-book-modal.blade.php --}}
<div id="edit-book-modal" class="fixed inset-0 bg-gray-800 bg-opacity-50 hidden items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg w-1/3">
        <div class="flex justify-between items-center border-b px-4 py-2">
            <h3 class="text-xl font-semibold">Edit Book</h3>
            <button id="close-modal-btn" class="text-gray-500 hover:text-gray-800">&times;</button>
        </div>
        
        {{-- Tambahkan div ini untuk memberikan padding pada form --}}
        <div class="p-4"> 
            <form id="update-book-form" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label for="edit-title" class="block text-gray-700">Title</label>
                    <input type="text" id="edit-title" name="title" class="w-full mt-1 p-2 border rounded">
                </div>

                <div class="mb-4">
                    <label for="edit-author-id" class="block text-gray-700">Author</label>
                    <select id="edit-author-id" name="author_id" class="w-full mt-1 p-2 border rounded">
                        @foreach($authors as $author)
                            <option value="{{ $author->id }}">{{ $author->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-4">
                    <label for="edit-publisher-id" class="block text-gray-700">Publisher</label>
                    <select id="edit-publisher-id" name="publisher_id" class="w-full mt-1 p-2 border rounded">
                        @foreach($publishers as $publisher)
                            <option value="{{ $publisher->id }}">{{ $publisher->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-4">
                    <label for="edit-category-id" class="block text-gray-700">Category</label>
                    <select id="edit-category-id" name="category_id" class="w-full mt-1 p-2 border rounded">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-4">
                    <label for="edit-shelf-id" class="block text-gray-700">Shelf</label>
                    <select id="edit-shelf-id" name="shelf_id" class="w-full mt-1 p-2 border rounded">
                        @foreach($shelves as $shelf)
                            <option value="{{ $shelf->id }}">{{ $shelf->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="edit-year" class="block text-gray-700">Year</label>
                    <input type="number" id="edit-year" name="year" class="w-full mt-1 p-2 border rounded">
                </div>

                <div class="flex items-center space-x-2 mt-6">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update</button>
                </form>
                <form id="delete-book-form" method="POST" onsubmit="return confirm('Are you sure you want to delete this book?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>