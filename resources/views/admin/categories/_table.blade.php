<tbody>
    @forelse ($categories as $index => $category)
        <tr class="cursor-pointer hover:bg-gray-100" data-category-id="{{ $category->id }}">
            <td class="py-2 px-4 border-b">{{ $categories->firstItem() + $index }}</td>
            <td class="py-2 px-4 border-b">{{ $category->name }}</td>
            <td class="py-2 px-4 border-b">{{ $category->description }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="3" class="py-4 text-center text-gray-500">No categories found.</td>
        </tr>
    @endforelse
</tbody>
