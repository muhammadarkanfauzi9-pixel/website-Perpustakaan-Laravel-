<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Tentukan apakah user berhak melakukan request ini.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Dapatkan aturan validasi yang berlaku untuk request.
     */
    public function rules(): array
    {
        return [
            // Aturan validasi untuk nama depan
            'first_name' => ['required', 'string', 'max:150'],
            
            // Aturan validasi untuk nama belakang
            'last_name'  => ['required', 'string', 'max:150'],
            
            // Aturan validasi untuk username, harus unik di tabel 'users'
            'username'   => ['required', 'string', 'max:150', 'unique:users'],
            
            // Aturan validasi untuk email, harus unik di tabel 'users'
            'email'      => ['required', 'string', 'email', 'max:150', 'unique:users'],
            
            // Aturan validasi untuk password, minimal 8 karakter dan harus dikonfirmasi
            'password'   => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    /**
     * Dapatkan pesan error kustom untuk aturan validasi.
     */
    public function messages(): array
    {
        return [
            // Pesan untuk validasi 'required'
            'first_name.required' => 'Nama depan harus diisi.',
            'last_name.required'  => 'Nama belakang harus diisi.',
            'username.required'   => 'Username harus diisi.',
            'email.required'      => 'Email harus diisi.',
            'password.required'   => 'Password harus diisi.',

            // Pesan untuk validasi format
            'email.email'         => 'Format email tidak valid.',

            // Pesan untuk validasi unik
            'username.unique'     => 'Username ini sudah digunakan.',
            'email.unique'        => 'Email ini sudah terdaftar.',

            // Pesan untuk validasi password
            'password.min'        => 'Password minimal harus 8 karakter.',
            'password.confirmed'  => 'Konfirmasi password tidak cocok.',
        ];
    }
}