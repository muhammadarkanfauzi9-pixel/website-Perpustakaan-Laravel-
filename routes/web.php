<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminPublisherController;
use App\Http\Controllers\Admin\AdminShelfController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminBookController;
use App\Http\Controllers\Admin\AdminBorrowingController;
use App\Http\Controllers\Admin\AdminAuthorController;
use App\Http\Controllers\BorrowingController;

// -------------------- Public --------------------
Route::get('/', [HomeController::class, 'index'])->name('landing');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');

Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');
Route::get('/books/category/{id}', [BookController::class, 'byCategory'])->name('books.byCategory');

// -------------------- Authenticated Users --------------------
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'home'])->name('home');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Rute peminjaman untuk user
    Route::post('/borrowings', [BorrowingController::class, 'store'])->name('borrowings.store');
    Route::get('/borrowings', [BorrowingController::class, 'index'])->name('borrowings.index');
});

// -------------------- Admin --------------------
Route::middleware(['auth','admin'])->prefix('admin')->name('admin.')->group(function(){

    // Dashboard
    Route::get('/', fn() => redirect()->route('admin.dashboard'));
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Users
    Route::resource('users', AdminUserController::class);

    // Publishers
    Route::resource('publishers', AdminPublisherController::class);

    // Shelves
    Route::resource('shelves', AdminShelfController::class);

    // Categories
    Route::resource('categories', AdminCategoryController::class);

    // Books
    Route::resource('books', AdminBookController::class);

    // Authors
    Route::resource('authors', AdminAuthorController::class);

    // Borrowings
    Route::resource('borrowings', AdminBorrowingController::class);
});