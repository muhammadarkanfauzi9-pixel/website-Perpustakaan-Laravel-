<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalBooks = Book::count();
        $totalUsers = User::count();

        return view('admin.dashboard', compact('totalBooks', 'totalUsers'));
    }
}
