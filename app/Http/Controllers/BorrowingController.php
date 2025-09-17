<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowingController extends Controller
{
    // Menampilkan semua data peminjaman milik siswa yang sedang login
    public function index()
    {
        $borrowings = Auth::user()->borrowings()->with('book')->paginate(10);
        return view('users.borrowings.index', compact('borrowings'));
    }

    // Menambah data peminjaman buku
    public function store(Request $request)
{
    $request->validate(['book_id' => 'required|exists:books,id']);

    $book = Book::findOrFail($request->book_id);
    if (!$book->isAvailable()) { // Panggil method isAvailable() yang sudah kita buat
        return redirect()->back()->with('error', 'Buku ini sedang tidak tersedia.');
    }

    Borrowing::create([
        'user_id' => Auth::id(),
        'book_id' => $request->book_id,
        'borrowed_at' => now(),
    ]);

    return redirect()->back()->with('success', 'Buku berhasil dipinjam!');
}

}