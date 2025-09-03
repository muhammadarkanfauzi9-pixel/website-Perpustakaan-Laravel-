<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminBookController;

// Route yang bisa diakses publik
// URL: /
Route::get('/', [HomeController::class, 'index'])->name('landing');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');

Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

// Route yang hanya bisa diakses setelah login
// URL: /home
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'home'])->name('home');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});

// Route untuk Admin Dashboard
// File: routes/web.php

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // Rute ini akan mengarahkan /admin ke dashboard
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users');
    Route::get('/books', [AdminBookController::class, 'index'])->name('admin.books');
});