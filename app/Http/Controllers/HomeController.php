<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Menangani halaman utama (landing page) yang dapat diakses publik.
     * URL: /
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Data dummy untuk Buku Terpopuler
        $books = [
            ['title' => 'The Lord of the Rings', 'author' => 'J.R.R. Tolkien', 'image' => asset('images/lord_of_the_rings.jpg')],
            ['title' => 'Harry Potter', 'author' => 'J.K. Rowling', 'image' => asset('images/Order_of_Phoenix_cover.jpg')],
            ['title' => 'Dune', 'author' => 'Frank Herbert', 'image' => asset('images/dune.jpeg')],
            ['title' => 'The Hobbit', 'author' => 'J.R.R. Tolkien', 'image' => asset('images/the_hobbit.jpg')],
        ];
        
        // Data dummy untuk Kategori
        $categories = ['Fiksi', 'Fantasi', 'Sains', 'Sejarah', 'Komputer'];

        // Kirim data ke view 'home'
        return view('home', compact('books', 'categories'));
    }

    /**
     * Menangani halaman home untuk pengguna yang sudah login.
     * URL: /home
     *
     * @return \Illuminate\View\View
     */
    public function home()
    {
        // Data dummy untuk Buku Terpopuler
        $books = [
            ['title' => 'The Lord of the Rings', 'author' => 'J.R.R. Tolkien', 'image' => asset('images/lord of the rings.jpg')],
            ['title' => 'Harry Potter', 'author' => 'J.K. Rowling', 'image' => asset('images/Order_of_Phoenix_cover.jpg')],
            ['title' => 'Dune', 'author' => 'Frank Herbert', 'image' => asset('images/dune.jpeg')],
            ['title' => 'The Hobbit', 'author' => 'J.R.R. Tolkien', 'image' => asset('images/the hobbit.jpg')],
        ];
        
        // Data dummy untuk Kategori
        $categories = ['Fiksi', 'Fantasi', 'Sains', 'Sejarah', 'Komputer'];

        // Ambil status login dan nama user
        $loggedIn = Auth::check();
        $userName = $loggedIn ? Auth::user()->name : null;

        // Kirim semua data ke view 'home'
        return view('home', compact('books', 'categories', 'loggedIn', 'userName'));
    }
}