<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Author::orderBy('name');

        if ($request->has('author_name')) {
            $query->where('name', 'like', '%' . $request->author_name . '%');
        }

        $authors = $query->paginate(3); // Menggunakan paginate(10) untuk memuat 10 item per halaman

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.authors._table', compact('authors'))->render(),
                'links' => $authors->links()->toHtml()
            ]);
        }

        return view('admin.authors.index', compact('authors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $author = Author::create($request->all());

        // Mengembalikan respons JSON jika permintaan adalah AJAX
        if ($request->ajax()) {
            return response()->json(['success' => true, 'author' => $author]);
        }

        return redirect()->route('admin.authors.index')->with('success', 'Author created successfully.');
    }

    /**
     * Show the specified resource.
     */
    public function show(Author $author)
    {
        // Metode show bisa digunakan untuk menampilkan detail, tapi showJson lebih spesifik
    }

    /**
     * Menampilkan data author dalam format JSON.
     */
    public function showJson(Author $author)
    {
        return response()->json($author);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $author)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $author->update($request->all());

        // Mengembalikan respons JSON jika permintaan adalah AJAX
        if ($request->ajax()) {
            return response()->json(['success' => true, 'author' => $author]);
        }

        return redirect()->route('admin.authors.index')->with('success', 'Author updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    // Di dalam metode destroy()
public function destroy(Author $author)
{
    // Hapus semua buku yang ditulis oleh penulis ini (ini akan memicu penghapusan catatan peminjaman)
    $author->books()->delete(); 

    // Sekarang, hapus penulis
    $author->delete();

    return redirect()->route('admin.authors.index')->with('success', 'Penulis berhasil dihapus!');
}
}