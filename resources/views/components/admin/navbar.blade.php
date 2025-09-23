<header class="bg-white border-b border-b-gray-200 shadow-md px-4 py-3 flex justify-between items-center md:px-8">
    <div class="font-semibold">Admin Library</div>
    <button class="lg:hidden rounded-md focus:outline-none" id="menuButton">
        <i class="fas fa-bars"></i>
    </button>
    <div class="hidden lg:flex lg:items-center lg:gap-4">
        <div class="relative inline-block text-left">
            <button type="button" class="flex items-center text-gray-600 hover:text-gray-900" onclick="toggleDropdown()">
                @if(Auth::user()->profile_image)
                    <img src="{{ asset('storage/' . Auth::user()->profile_image) }}"
                         alt="Profile" class="w-8 h-8 rounded-full mr-2">
                @else
                    <div class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center mr-2">
                        <i class="fas fa-user"></i>
                    </div>
                @endif
                <span class="font-medium text-sm">{{ Auth::user()->name }}</span>
                <i class="fas fa-chevron-down ml-1 text-xs"></i>
            </button>
            <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50">
                <div class="py-1">
                    <a href="{{ route('admin.settings.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-user-cog mr-2"></i>Profile Settings
                    </a>
                    <a href="{{ route('admin.settings.password.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-lock mr-2"></i>Change Password
                    </a>
                    <hr class="my-1">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
function toggleDropdown() {
    const dropdown = document.getElementById('profileDropdown');
    dropdown.classList.toggle('hidden');
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    const dropdown = document.getElementById('profileDropdown');
    const button = event.target.closest('button');

    if (!button || !button.onclick || button.onclick.toString().indexOf('toggleDropdown') === -1) {
        dropdown.classList.add('hidden');
    }
});
</script>
