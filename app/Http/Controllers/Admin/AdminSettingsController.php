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
            // Delete old profile image if exists
            if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
                Storage::disk('public')->delete($user->profile_image);
            }

            // Store new profile image
            $imageName = time() . '.' . $request->profile_image->extension();
            $request->profile_image->storeAs('public', $imageName);
            $data['profile_image'] = $imageName;
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
