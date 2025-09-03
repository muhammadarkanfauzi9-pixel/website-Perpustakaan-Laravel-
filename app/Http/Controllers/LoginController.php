<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class LoginController extends Controller
{
    /**
     * Tampilkan halaman login.
     */
    public function index(): View
    {
        return view('login');
    }

    /**
     * Tangani permintaan otentikasi.
     */
    public function authenticate(Request $request): RedirectResponse
    {
        // Validasi input
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required'],
        ]);

        // Tentukan field yang akan digunakan untuk otentikasi
        $loginType = filter_var($request->input('username'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Buat array kredensial untuk percobaan otentikasi
        $attemptCredentials = [
            $loginType => $credentials['username'],
            'password' => $credentials['password'],
        ];

        // Coba otentikasi pengguna
        if (Auth::attempt($attemptCredentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            }

            return redirect()->intended(route('home'));
        }

        // Jika otentikasi gagal
        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    /**
     * Tangani proses logout pengguna.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}