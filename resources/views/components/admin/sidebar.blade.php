<nav class="bg-white border-r border-r-gray-200 text-gray-800 w-64 space-y-1 py-6 px-2 absolute inset-y-0 left-0 transform -translate-x-full lg:relative lg:translate-x-0 transition duration-200 ease-in-out md:px-4" id="sidebar">
    <a href="{{ route('admin.dashboard') }}"
        class="bg-gray-200 text-sm flex items-center gap-3 px-4 py-3 rounded transition-all duration-300 hover:bg-gray-200">
        <i class="fas fa-home"></i>
        <span>Dashboard</span>
    </a>
    <a href="{{ route('admin.users') }}"
        class="text-sm flex items-center gap-3 px-4 py-3 rounded transition-all duration-300 hover:bg-gray-200">
        <i class="fas fa-users"></i>
        <span>Users</span>
    </a>
    <a href="{{ route('admin.books') }}"
        class="text-sm flex items-center gap-3 px-4 py-3 rounded transition-all duration-300 hover:bg-gray-200">
        <i class="fas fa-gear"></i>
        <span>Settings</span>
    </a>

    <a href="{{ route('admin.books') }}"
        class="text-sm flex items-center gap-3 px-4 py-3 rounded transition-all duration-300 hover:bg-gray-200">
        <i class="fas fa-book"></i>
        <span>Books</span>
    </a>

    <a href="{{ route('logout') }}"
        class="text-sm flex items-center gap-3 px-4 py-3 rounded transition-all duration-300 hover:bg-gray-200">
        <i class="fas fa-sign-out-alt"></i>
        <span>Logout</span>
    </a>
</nav>