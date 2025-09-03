<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\User;

class RegisterController extends Controller
{
    /**
     * Tampilkan halaman form register
     */
    public function index(): View
    {
        return view('register');
    }

    /**
     * Proses data register yang dikirim dari form
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        // Ambil data yang sudah divalidasi dari RegisterRequest
        $validatedData = $request->validated();

        // Gabungkan first_name dan last_name menjadi satu kolom 'name'
        $validatedData['name'] = $validatedData['first_name'] . ' ' . $validatedData['last_name'];
        
        // Hapus kolom first_name dan last_name karena tidak ada di tabel users
        unset($validatedData['first_name']);
        unset($validatedData['last_name']);

        // Enkripsi password agar aman
        $validatedData['password'] = bcrypt($validatedData['password']);

        // Simpan data ke database
        User::create($validatedData);

        // Arahkan pengguna ke halaman login setelah registrasi berhasil
        // Tambahkan pesan sukses ke sesi
        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
}