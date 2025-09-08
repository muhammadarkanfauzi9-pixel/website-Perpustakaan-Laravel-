<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category; // Pastikan untuk mengimpor model Category
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
    /**
     * Menampilkan daftar semua kategori.
     */
    public function index()
    {
        // Ambil semua kategori dari database dan lakukan pagination
        $categories = Category::paginate(10);
        
        // Kembalikan view dengan data kategori
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Menampilkan form untuk membuat kategori baru.
     */
    public function create()
    {
        // ... Logika Anda di sini
    }

    /**
     * Menyimpan kategori yang baru dibuat ke dalam storage.
     */
    public function store(Request $request)
    {
        // ... Logika Anda di sini
    }

    /**
     * Menampilkan kategori yang ditentukan.
     */
    public function show(Category $category)
    {
        // ... Logika Anda di sini
    }

    /**
     * Menampilkan form untuk mengedit kategori yang ditentukan.
     */
    public function edit(Category $category)
    {
        // ... Logika Anda di sini
    }

    /**
     * Memperbarui kategori yang ditentukan di storage.
     */
    public function update(Request $request, Category $category)
    {
        // ... Logika Anda di sini
    }

    /**
     * Menghapus kategori yang ditentukan dari storage.
     */
    public function destroy(Category $category)
    {
        // ... Logika Anda di sini
    }
}