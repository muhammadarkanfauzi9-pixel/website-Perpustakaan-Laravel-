<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Ganti dengan mengambil data dari database di sini
        // Misalnya:
        // $totalBooks = \App\Models\Book::count();
        // $totalUsers = \App\Models\User::count();

        // Contoh data dummy:
        $totalBooks = 100;
        $totalUsers = 50;

        // Kirim data ke view
        return view('admin.dashboard', compact('totalBooks', 'totalUsers'));
    }
}