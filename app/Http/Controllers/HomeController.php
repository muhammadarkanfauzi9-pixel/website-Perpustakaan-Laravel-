<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Book;
use App\Models\Category;

class HomeController extends Controller
{
    /**
     * Landing page (public) - URL: /
     */
    public function index()
    {
        $books = Book::with(['author', 'category'])->latest()->take(8)->get();
        $categories = Category::all();

        $borrowings = null;

        if (Auth::check()) {
            $borrowings = Auth::user()->borrowings()->with('book')->latest()->take(5)->get();
        }

        return view('home', compact('books', 'categories', 'borrowings'));
    }

    /**
     * Halaman home setelah login - URL: /home
     */
    public function home()
    {
        $books = Book::latest()->take(8)->get();
        $categories = Category::all();

        // Ambil data peminjaman hanya di sini, saat user sudah login
        $borrowings = Auth::check() ? Auth::user()->borrowings()->with('book')->latest()->take(5)->get() : null;

        return view('home', compact('books', 'categories', 'borrowings'));
    }
}