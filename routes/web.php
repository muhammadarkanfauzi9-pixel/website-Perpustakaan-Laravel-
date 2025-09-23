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
use App\Http\Controllers\Admin\PublisherController;
use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\Admin\AdminSettingsController;

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
Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'home'])->name('home');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::match(['post', 'put', 'patch'], '/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.profile.update');
    Route::get('/settings/change-password', [SettingsController::class, 'showChangePassword'])->name('settings.password.show');
    Route::post('/settings/change-password', [SettingsController::class, 'updatePassword'])->name('settings.password.update');

    // Rute peminjaman untuk user
    Route::post('/borrowings', [BorrowingController::class, 'store'])->name('borrowings.store');
    Route::get('/borrowings', [BorrowingController::class, 'index'])->name('borrowings.index');
});

// -------------------- Admin --------------------
Route::middleware(['web', 'auth','admin'])->prefix('admin')->name('admin.')->group(function(){

    // Dashboard
    Route::get('/', fn() => redirect()->route('admin.dashboard'));
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Settings
    Route::get('/settings', [AdminSettingsController::class, 'index'])->name('settings.index');
    Route::match(['put', 'patch'], '/settings/profile', [AdminSettingsController::class, 'updateProfile'])
    ->name('settings.profile.update');
    Route::get('/settings/change-password', [AdminSettingsController::class, 'showChangePassword'])->name('settings.password.show');
    Route::post('/settings/change-password', [AdminSettingsController::class, 'updatePassword'])->name('settings.password.update');

    // Users
    Route::resource('users', AdminUserController::class);
    Route::get('users/{user}/json', [AdminUserController::class, 'showJson'])->name('users.json');

    // Publishers
    Route::resource('publishers', AdminPublisherController::class);
    Route::get('publishers/{publisher}/json', [AdminPublisherController::class, 'showJson'])->name('publishers.json');
    Route::get('searchPublisher', [AdminPublisherController::class, 'search'])->name('publishers.search');

    // Shelves
    Route::resource('shelves', AdminShelfController::class);
    Route::get('shelves/{shelf}/edit', [AdminShelfController::class, 'edit'])->name('shelves.edit');

    // Categories
    Route::resource('categories', AdminCategoryController::class);
    Route::get('categories/{category}/json', [AdminCategoryController::class, 'json'])->name('categories.json');

    // Books
    Route::resource('books', AdminBookController::class);

    // Authors
    Route::resource('authors', AdminAuthorController::class);
    Route::get('authors/{author}/json', [AdminAuthorController::class, 'showJson'])->name('authors.json');

    // Borrowings
    Route::resource('borrowings', AdminBorrowingController::class);
});
