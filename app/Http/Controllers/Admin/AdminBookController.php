<?php

namespace App\Http\Controllers\Admin;

use App\Models\Book;
use App\Models\Publisher;
use App\Models\Shelf;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;

class AdminBookController extends Controller
{
    public function index()
    {
        // Menggunakan with() untuk memuat relasi (eager loading)
        // Menggunakan paginate() untuk pagination
        $books = Book::with(['publisher', 'shelf', 'category'])->paginate(10);
        return view('admin.books.index', compact('books'));
    }

    public function create()
    {
        $publishers = Publisher::all();
        $shelves = Shelf::all();
        $categories = Category::all();
        return view('admin.books.create', compact('publishers', 'shelves', 'categories'));
    }

    public function store(StoreBookRequest $request)
    {
        $validated = $request->validated();
        Book::create($validated);
        return redirect()->route('admin.books.index')->with('success', 'Book added successfully!');
    }

    public function show(Book $book)
    {
        // Eager load relasi untuk tampilan detail
        $book->load('publisher', 'shelf', 'category');
        return view('admin.books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        $publishers = Publisher::all();
        $shelves = Shelf::all();
        $categories = Category::all();
        return view('admin.books.edit', compact('book', 'publishers', 'shelves', 'categories'));
    }

    public function update(UpdateBookRequest $request, Book $book)
    {
        $validated = $request->validated();
        $book->update($validated);
        return redirect()->route('admin.books.index')->with('success', 'Book updated successfully!');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('admin.books.index')->with('success', 'Book deleted successfully!');
    }
}