<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUserController extends Controller
{
    // Tampil halaman users
    public function index()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    // Simpan user/admin baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:user,admin',
        ]);

        // Buat username otomatis dari name
        $username = Str::slug($request->name) . rand(100, 999);

        User::create([
            'name' => $request->name,
            'username' => $username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users')->with('success', 'User created successfully!');
    }

    // Ambil data user untuk modal
    public function json($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    // Hapus user/admin
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Jangan hapus diri sendiri
        if (auth()->id() == $user->id) {
            return response()->json(['error' => 'You cannot delete yourself.'], 400);
        }

        $user->delete();
        return response()->json(['success' => 'User deleted successfully!']);
    }
}
