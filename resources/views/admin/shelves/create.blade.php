@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Add Shelf</h1>

    <form action="{{ route('admin.shelves.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label for="name" class="block font-medium">Shelf Name</label>
            <input type="text" name="name" id="name" 
                   class="w-full border rounded-lg p-2" required>
            @error('name')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">
            Save
        </button>
    </form>
</div>
@endsection
