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
        return view('borrowings.index', compact('borrowings'));
    }

    // Menambah data peminjaman buku
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);

        // Buat data peminjaman baru
        Borrowing::create([
            'user_id' => Auth::id(),
            'book_id' => $request->book_id,
            'borrowed_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Buku berhasil dipinjam!');
    }

    // Mengembalikan buku yang sudah dipinjam
    public function update(Request $request, Borrowing $borrowing)
    {
        // Pastikan pengguna yang mengembalikan buku adalah pemilik data peminjaman
        if ($borrowing->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $borrowing->update([
            'returned_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Buku berhasil dikembalikan!');
    }
}