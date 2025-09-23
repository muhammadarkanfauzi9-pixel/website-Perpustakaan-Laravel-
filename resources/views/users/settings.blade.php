@extends('layouts.app')

@section('title', 'Settings')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-900">Settings</h1>
                <p class="text-gray-600">Manage your account settings and preferences.</p>
            </div>

            <div class="p-6">
                @if(session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Profile Settings -->
                    <div class="lg:col-span-2">
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h2 class="text-lg font-semibold text-gray-900 mb-4">Profile Information</h2>

                            <form action="{{ route('settings.profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                                @csrf

                                <!-- Profile Image -->
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Profile Image</label>
                                    <div class="flex items-center space-x-4">
                                        <div class="w-20 h-20 rounded-full bg-gray-200 overflow-hidden">
                                            @if($user->profile_image)
                                                <img src="{{ asset('storage/profile_images/' . $user->profile_image) }}"
                                                     alt="Profile Image" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                    <i class="fas fa-user text-2xl"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <input type="file" name="profile_image" id="profile_image"
                                                   accept="image/*" class="hidden" onchange="previewImage(this)">
                                            <label for="profile_image"
                                                   class="cursor-pointer bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                                                Change Image
                                            </label>
                                            <p class="text-sm text-gray-500 mt-1">JPG, PNG or GIF. Max size 2MB.</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Name -->
                                <div class="mb-4">
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>

                                <!-- Username -->
                                <div class="mb-4">
                                    <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                                    <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>

                                <!-- Email -->
                                <div class="mb-6">
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>

                                <button type="submit"
                                        class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    Update Profile
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div>
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>

                            <div class="space-y-3">
                                <a href="{{ route('settings.password.show') }}"
                                   class="block w-full text-left bg-yellow-500 text-white px-4 py-3 rounded-md hover:bg-yellow-600">
                                    <i class="fas fa-lock mr-2"></i>
                                    Change Password
                                </a>

                                <a href="{{ route('borrowings.index') }}"
                                   class="block w-full text-left bg-green-500 text-white px-4 py-3 rounded-md hover:bg-green-600">
                                    <i class="fas fa-book mr-2"></i>
                                    My Borrowings
                                </a>

                                <a href="{{ route('home') }}"
                                   class="block w-full text-left bg-purple-500 text-white px-4 py-3 rounded-md hover:bg-purple-600">
                                    <i class="fas fa-home mr-2"></i>
                                    Back to Home
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const maxSize = 2 * 1024 * 1024; // 2MB

        if (file.size > maxSize) {
            alert('File size must be less than 2MB');
            input.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            // You can add image preview functionality here if needed
        };
        reader.readAsDataURL(file);
    }
}

// Add form debugging
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('profileForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            console.log('Form submitted!');
            console.log('Form data:', new FormData(form));

            // Show loading state
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.textContent = 'Updating...';
            }
        });
    }

    // Debug file input
    const fileInput = document.getElementById('profile_image');
    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            console.log('File selected:', e.target.files[0]);
            if (e.target.files[0]) {
                console.log('File size:', e.target.files[0].size);
                console.log('File type:', e.target.files[0].type);
            }
        });
    }
});
</script>
@endsection
