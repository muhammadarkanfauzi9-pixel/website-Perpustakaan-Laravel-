<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUserController extends Controller
{
    /**
     * Tampilkan daftar user + support search & pagination (AJAX).
     */
    public function index(Request $request)
    {
        $query = User::orderBy('name');

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('username', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->paginate(2);

        // Jika AJAX → kembalikan JSON (untuk fetch)
        if ($request->ajax()) {
            return response()->json([
                'html'  => view('admin.users._table', compact('users'))->render(),
                'links' => $users->links()->toHtml(),
            ]);
        }

        return view('admin.users.index', compact('users'));
    }

    /**
     * Simpan user/admin baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role'     => 'required|in:user,admin',
        ]);

        // Buat username otomatis dari name
        $username = Str::slug($request->name) . rand(100, 999);

        User::create([
            'name'     => $request->name,
            'username' => $username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return redirect()->route('admin.users.index')
                         ->with('success', 'User created successfully!');
    }

    /**
     * Ambil data user untuk modal edit (JSON).
     */
    public function showJson(User $user)
    {
        return response()->json($user);
    }

    /**
     * Update data user.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role'  => 'required|in:user,admin',
        ]);

        $user->update($request->only(['name', 'email', 'role']));

        // Kalau submit pakai form biasa → redirect
        return redirect()->route('admin.users.index')
                         ->with('success', 'User updated successfully!');

        // Kalau mau AJAX, bisa pakai:
        // return response()->json(['success' => 'User updated successfully!']);
    }

    /**
     * Hapus user/admin.
     */
    public function destroy(User $user)
    {
        // Jangan hapus diri sendiri
        if (auth()->id() == $user->id) {
            return response()->json(['error' => 'You cannot delete yourself.'], 400);
        }

        $user->delete();

        return response()->json(['success' => 'User deleted successfully!']);
    }
}
