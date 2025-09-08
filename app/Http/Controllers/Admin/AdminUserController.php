<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    /**
     * Menampilkan daftar pengguna (user).
     */
   public function index()
{
    $users = \App\Models\User::paginate(10);
    return view('admin.users.index', compact('users'));
}
}