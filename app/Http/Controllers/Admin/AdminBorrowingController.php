<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Borrowing;
use App\Models\Book;
use App\Models\User;
use Carbon\Carbon;

class AdminBorrowingController extends Controller
{
    // List semua peminjaman
    public function index(Request $request)
    {
        $query = Borrowing::with(['user', 'book'])->orderBy('borrowed_at', 'desc');

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            })->orWhereHas('book', function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%');
            });
        }

        $borrowings = $query->paginate(2);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.borrowings._table', compact('borrowings'))->render(),
                'links' => $borrowings->links()->toHtml()
            ]);
        }

        return view('admin.borrowings.index', compact('borrowings'));
    }

    // Form create peminjaman
    public function create()
    {
        $books = Book::all();
        $users = User::all();
        return view('admin.borrowings.create', compact('books', 'users'));
    }

    // Simpan peminjaman baru
    public function store(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'book_id' => 'required|exists:books,id',
    ]);

    // Tambahkan pengecekan ini
    $book = Book::findOrFail($request->book_id);
    if (!$book->isAvailable()) {
        return redirect()->back()->with('error', 'Buku ini sedang dipinjam.');
    }

    Borrowing::create([
        'user_id' => $request->user_id,
        'book_id' => $request->book_id,
        'borrowed_at' => Carbon::now(),
    ]);

    return redirect()->route('admin.borrowings.index')->with('success', 'Borrowing created successfully!');
}

    // Form edit
    public function edit($id)
    {
        $borrowing = Borrowing::findOrFail($id);
        $books = Book::all();
        $users = User::all();
        return view('admin.borrowings.edit', compact('borrowing', 'books', 'users'));
    }

    // Update peminjaman
    public function update(Request $request, Borrowing $borrowing)
{
    // Cek apakah buku sudah dikembalikan atau belum
    if ($borrowing->returned_at) {
        return redirect()->back()->with('error', 'Buku sudah dikembalikan sebelumnya.');
    }

    $borrowing->update([
        'returned_at' => now(),
    ]);

    return redirect()->back()->with('success', 'Pengembalian buku berhasil dikonfirmasi.');
}

    // Hapus peminjaman
    public function destroy($id)
    {
        $borrowing = Borrowing::findOrFail($id);
        $borrowing->delete();
        return redirect()->route('admin.borrowings.index')->with('success', 'Borrowing deleted successfully!');
    }

    // Ambil data peminjaman untuk modal
    public function show($id)
    {
        $borrowing = Borrowing::with(['user', 'book'])->findOrFail($id);
        return response()->json($borrowing);
    }
}
