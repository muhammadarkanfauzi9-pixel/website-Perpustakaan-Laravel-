<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;

class BookController extends Controller
{
    // Halaman Home (semua kategori + buku populer)
    public function index()
    {
        // Mendefinisikan variabel $categories di sini
        $categories = Category::all(); 

        $books = Book::with(['author', 'publisher', 'category'])->paginate(12);

        // Mengirimkan kedua variabel ke tampilan
        return view('books.index', compact('books', 'categories'));
    }

    public function home()
    {
        $categories = Category::all();

        $books = Book::with(['author', 'publisher', 'category', 'borrowings']) // Tambahkan 'borrowings' untuk mengecek ketersediaan
            ->latest()
            ->take(8)
            ->get();

        return view('home', compact('categories', 'books'));
    }

    // Buku berdasarkan kategori
    public function byCategory($id)
    {
        $categories = Category::all();
        $category = Category::findOrFail($id);

        $books = Book::with(['author', 'category', 'borrowings']) // Tambahkan 'borrowings'
            ->where('category_id', $id)
            ->paginate(8);

        return view('home', compact('categories', 'books', 'category'));
    }

    public function show($id){
        $book = Book::with(['author', 'category', 'borrowings'])->findOrFail($id);
        return view('books.show', compact('book'));
    }
}