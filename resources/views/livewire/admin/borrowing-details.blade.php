<div>
    @if($showModal)
    <div class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg w-1/2 p-6 relative">
            <h2 class="text-xl font-bold mb-4">Borrowing Details</h2>
            <button wire:click="closeModal" class="absolute top-2 right-2 text-gray-600 hover:text-gray-900">&times;</button>

            @if($borrowing)
                <div class="mb-2"><strong>User:</strong> {{ $borrowing->user->name }}</div>
                <div class="mb-2"><strong>Book:</strong> {{ $borrowing->book->title }}</div>
                <div class="mb-2"><strong>Borrowed At:</strong> {{ $borrowing->borrowed_at->format('d M Y') }}</div>
                <div class="mb-2"><strong>Returned At:</strong> 
                    @if($borrowing->returned_at)
                        {{ $borrowing->returned_at->format('d M Y') }}
                    @else
                        Not returned yet
                    @endif
                </div>
                <div class="mb-2"><strong>Status:</strong> 
                    @if($borrowing->returned_at)
                        <span class="text-green-600 font-semibold">Returned</span>
                    @else
                        <span class="text-yellow-600 font-semibold">Borrowed</span>
                    @endif
                </div>
            @else
                <p>No borrowing details available.</p>
            @endif

            <div class="mt-4 text-right">
                <button wire:click="closeModal" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">Close</button>
            </div>
        </div>
    </div>
    @endif
</div>
