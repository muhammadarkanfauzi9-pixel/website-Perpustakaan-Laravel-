<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shelf; // Pastikan untuk mengimpor model Shelf
use Illuminate\Http\Request;

class AdminShelfController extends Controller
{
    /**
     * Menampilkan daftar semua rak.
     */
    public function index()
    {
        // Ambil semua rak dari database dan lakukan pagination
        $shelves = Shelf::paginate(10);
        
        // Kembalikan view dengan data rak
        return view('admin.shelves.index', compact('shelves'));
    }

    /**
     * Menampilkan form untuk membuat rak baru.
     */
    public function create()
    {
        // Tambahkan logika Anda untuk menampilkan form create di sini
    }

    /**
     * Menyimpan rak yang baru dibuat ke dalam storage.
     */
    public function store(Request $request)
    {
        // Tambahkan logika Anda untuk menyimpan rak baru di sini
    }

    /**
     * Menampilkan rak yang ditentukan.
     */
    public function show(Shelf $shelf)
    {
        // Tambahkan logika Anda untuk menampilkan rak tunggal di sini
    }

    /**
     * Menampilkan form untuk mengedit rak yang ditentukan.
     */
    public function edit(Shelf $shelf)
    {
        // Tambahkan logika Anda untuk menampilkan form edit di sini
    }

    /**
     * Memperbarui rak yang ditentukan di storage.
     */
    public function update(Request $request, Shelf $shelf)
    {
        // Tambahkan logika Anda untuk memperbarui rak di sini
    }

    /**
     * Menghapus rak yang ditentukan dari storage.
     */
    public function destroy(Shelf $shelf)
    {
        // Tambahkan logika Anda untuk menghapus rak di sini
    }
}