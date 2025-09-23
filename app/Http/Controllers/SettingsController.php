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

        // Add debugging
        \Log::info('Profile update request received', [
            'user_id' => $user->id,
            'has_file' => $request->hasFile('profile_image'),
            'all_files' => $request->allFiles(),
            'all_data' => $request->all()
        ]);

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            \Log::info('Processing profile image upload', [
                'original_name' => $request->profile_image->getClientOriginalName(),
                'size' => $request->profile_image->getSize(),
                'mime_type' => $request->profile_image->getMimeType()
            ]);

            // Delete old profile image if exists
            if ($user->profile_image && Storage::disk('public')->exists('profile_images/' . $user->profile_image)) {
                Storage::disk('public')->delete('profile_images/' . $user->profile_image);
                \Log::info('Deleted old profile image', ['old_image' => $user->profile_image]);
            }

            // Store new profile image
            $imageName = time() . '.' . $request->profile_image->extension();
            \Log::info('Attempting to store new image', ['image_name' => $imageName]);

            $result = Storage::disk('public')->putFileAs('profile_images', $request->profile_image, $imageName);
            \Log::info('Image storage result', ['result' => $result, 'image_name' => $imageName]);

            $data['profile_image'] = $imageName;

            \Log::info('Profile image updated successfully', ['new_image' => $imageName]);
        } else {
            \Log::info('No profile image in request');
        }

        // Update user profile
        $user->update($data);

        \Log::info('Profile updated successfully', ['user_id' => $user->id, 'profile_image' => $user->profile_image]);

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
