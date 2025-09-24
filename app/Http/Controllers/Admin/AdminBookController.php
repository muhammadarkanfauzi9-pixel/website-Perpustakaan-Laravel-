<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\Shelf;
use App\Models\Category;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use Illuminate\Support\Facades\Storage;

class AdminBookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with(['author', 'publisher', 'category', 'shelf'])->orderBy('title');

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where('title', 'like', '%' . $search . '%')
                  ->orWhereHas('author', function ($q) use ($search) {
                      $q->where('name', 'like', '%' . $search . '%');
                  })
                  ->orWhereHas('category', function ($q) use ($search) {
                      $q->where('name', 'like', '%' . $search . '%');
                  });
        }

        $books = $query->paginate(2);
        $authors = Author::all();
        $publishers = Publisher::all();
        $categories = Category::all();
        $shelves = Shelf::all();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.books._table', compact('books'))->render(),
                'links' => $books->links()->toHtml()
            ]);
        }

        return view('admin.books.index', compact('books', 'authors', 'publishers', 'categories', 'shelves'));
    }

    // Metode ini digunakan untuk mengambil data JSON (sebelumnya bernama `json`)
    public function show(Book $book)
    {
        return response()->json($book->load(['author', 'publisher', 'category', 'shelf']));
    }

    public function create()
    {
        $publishers = Publisher::all();
        $shelves = Shelf::all();
        $categories = Category::all();
        $authors = Author::all();

        return view('admin.books.create', compact('publishers', 'shelves', 'categories', 'authors'));
    }

    public function store(StoreBookRequest $request)
    {
        $data = $request->validated();

        if ($request->filled('author_name')) {
            $author = Author::create(['name' => $request->author_name]);
            $data['author_id'] = $author->id;
        } else {
            $data['author_id'] = $request->author_id;
        }

        if ($request->hasFile('book_img')) {
            $path = $request->file('book_img')->store('books', 'public');
            $data['book_img'] = $path;
        } else {
            $data['book_img'] = 'books/default.png';
        }

        Book::create($data);

        return redirect()->route('admin.books.index')->with('success', 'Book added successfully.');
    }

    public function edit(Book $book)
    {
        $publishers = Publisher::all();
        $shelves = Shelf::all();
        $categories = Category::all();
        $authors = Author::all();

        return view('admin.books.edit', compact('book', 'publishers', 'shelves', 'categories', 'authors'));
    }

    public function update(UpdateBookRequest $request, Book $book)
    {
        $data = $request->validated();

        if ($request->filled('author_name')) {
            $author = Author::create(['name' => $request->author_name]);
            $data['author_id'] = $author->id;
        }

        if ($request->hasFile('book_img')) {
            if ($book->book_img && $book->book_img !== 'books/default.png' && Storage::disk('public')->exists($book->book_img)) {
                Storage::disk('public')->delete($book->book_img);
            }
            $path = $request->file('book_img')->store('books', 'public');
            $data['book_img'] = $path;
        } else {
            $data['book_img'] = $book->book_img;
        }

        $book->update($data);

        return redirect()->route('admin.books.index')->with('success', 'Book updated successfully.');
    }

    public function destroy(Book $book)
{
    // Hapus semua data peminjaman yang terkait dengan buku ini terlebih dahulu
    $book->borrowings()->delete();

    // Hapus file gambar buku (jika ada)
    if ($book->book_img && $book->book_img !== 'books/default.png' && Storage::disk('public')->exists($book->book_img)) {
        Storage::disk('public')->delete($book->book_img);
    }

    // Hapus buku
    $book->delete();

    return redirect()->route('admin.books.index')->with('success', 'Book deleted successfully.');
}
}