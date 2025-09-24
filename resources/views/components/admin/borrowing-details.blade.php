<div>
    @if($showModal)
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-lg shadow-lg w-1/2 p-6">
                <h2 class="text-xl font-bold mb-4">Borrowing Details</h2>

                @if($borrowing)
                    <p><strong>User:</strong> {{ $borrowing->user->name ?? '-' }}</p>
                    <p><strong>Book:</strong> {{ $borrowing->book->title ?? '-' }}</p>
                    <p><strong>Borrowed At:</strong> {{ $borrowing->created_at }}</p>
                @endif

                <button wire:click="closeModal" class="mt-4 px-4 py-2 bg-red-600 text-white rounded">
                    Close
                </button>
            </div>
        </div>
    @endif
</div>
