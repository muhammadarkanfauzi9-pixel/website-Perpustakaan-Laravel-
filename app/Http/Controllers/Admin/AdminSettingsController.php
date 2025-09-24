<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Models\User;

class AdminSettingsController extends Controller
{
    /**
     * Show the admin settings page.
     */
    public function index()
    {
        $user = auth()->user();
        return view('admin.settings', compact('user'));
    }

    /**
     * Update admin profile.
     */
    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = auth()->user();
        $data = $request->validated();

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
    // Hapus foto lama
    if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
        Storage::disk('public')->delete($user->profile_image);
    }

    // Tentukan folder berdasarkan role
    $folder = $user->is_admin ? 'profile_images/admin' : 'profile_images/users';

    // Simpan foto baru
    $path = $request->file('profile_image')->store('profile_images/admin', 'public');

    // Simpan ke DB
    $data['profile_image'] = $path;
}

        // Update user profile
        $user->update($data);

        return redirect()->route('admin.settings.index')
                        ->with('success', 'Profile updated successfully!');
    }

    /**
     * Show the change password form.
     */
    public function showChangePassword()
    {
        return view('admin.change-password');
    }

    /**
     * Update admin password.
     */
    public function updatePassword(ChangePasswordRequest $request)
    {
        $user = auth()->user();

        // Update password
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('admin.settings.index')
                        ->with('success', 'Password changed successfully!');
    }
}
