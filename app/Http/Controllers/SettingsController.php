<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Models\User;

class SettingsController extends Controller
{
    /**
     * Show the settings page.
     */
    public function index()
    {
        $user = auth()->user();
        return view('users.settings', compact('user'));
    }

    /**
     * Update user profile.
     */
    public function updateProfile(UpdateProfileRequest $request)
{
    $user = auth()->user();
    $data = $request->validated();

    // Handle profile image upload
    if ($request->hasFile('profile_image')) {
        // Hapus foto lama kalau ada
        if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
            Storage::disk('public')->delete($user->profile_image);
        }

        // Tentukan folder khusus untuk user
        $folder = 'profile_images/users';

        // Simpan foto baru
        $path = $request->file('profile_image')->store('profile_images/users', 'public');

        // Simpan ke DB (contoh: "profile_images/users/1758641643.png")
        $data['profile_image'] = $path;
    }

    // Update user profile
    $user->update($data);

    return redirect()->route('settings.index')
                     ->with('success', 'Profile updated successfully!');
}


    /**
     * Show the change password form.
     */
    public function showChangePassword()
    {
        return view('users.change-password');
    }

    /**
     * Update user password.
     */
    public function updatePassword(ChangePasswordRequest $request)
    {
        $user = auth()->user();

        // Update password
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('settings.index')
                        ->with('success', 'Password changed successfully!');
    }
}
