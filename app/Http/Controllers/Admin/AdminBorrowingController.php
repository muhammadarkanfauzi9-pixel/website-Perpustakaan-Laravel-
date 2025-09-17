<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminBorrowingController extends Controller
{
    // List semua peminjaman
    public function index()
    {
        $borrowings = Borrowing::with(['user', 'book'])->paginate(10);
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
}
