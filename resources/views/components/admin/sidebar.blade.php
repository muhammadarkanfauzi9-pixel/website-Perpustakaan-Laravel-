<nav class="bg-white border-r border-r-gray-200 text-gray-800 w-64 space-y-1 py-6 px-2 absolute inset-y-0 left-0 transform -translate-x-full lg:relative lg:translate-x-0 transition duration-200 ease-in-out md:px-4" id="sidebar">
    {{-- Dashboard --}}
    <a href="{{ route('admin.dashboard') }}"
        class="text-sm flex items-center gap-3 px-4 py-3 rounded transition-all duration-300 hover:bg-gray-200 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-200 font-medium' : '' }}">
        <i class="fas fa-home"></i>
        <span>Dashboard</span>
    </a>

    {{-- Users --}}
    <a href="{{ route('admin.users.index') }}"
        class="text-sm flex items-center gap-3 px-4 py-3 rounded transition-all duration-300 hover:bg-gray-200 {{ request()->routeIs('admin.users') ? 'bg-gray-200 font-medium' : '' }}">
        <i class="fas fa-users"></i>
        <span>Users Management</span>
    </a>

    {{-- Books --}}
    <a href="{{ route('admin.books.index') }}"
        class="text-sm flex items-center gap-3 px-4 py-3 rounded transition-all duration-300 hover:bg-gray-200 {{ request()->routeIs('admin.books.*') ? 'bg-gray-200 font-medium' : '' }}">
        <i class="fas fa-book"></i>
        <span>Books</span>
    </a>

    {{-- Settings --}}
    <a href="{{ route('admin.settings.index') }}"
        class="text-sm flex items-center gap-3 px-4 py-3 rounded transition-all duration-300 hover:bg-gray-200 {{ request()->routeIs('admin.settings.*') ? 'bg-gray-200 font-medium' : '' }}">
        <i class="fas fa-gear"></i>
        <span>Settings</span>
    </a>

    {{-- Publishers --}}
    <a href="{{ route('admin.publishers.index') }}"
        class="text-sm flex items-center gap-3 px-4 py-3 rounded transition-all duration-300 hover:bg-gray-200 {{ request()->routeIs('admin.publishers.*') ? 'bg-gray-200 font-medium' : '' }}">
        <i class="fas fa-building"></i>
        <span>Publishers</span>
    </a>

    {{-- Shelves --}}
    <a href="{{ route('admin.shelves.index') }}"
        class="text-sm flex items-center gap-3 px-4 py-3 rounded transition-all duration-300 hover:bg-gray-200 {{ request()->routeIs('admin.shelves.*') ? 'bg-gray-200 font-medium' : '' }}">
        <i class="fas fa-layer-group"></i>
        <span>Shelves</span>
    </a>

    {{-- Categories --}}
    <a href="{{ route('admin.categories.index') }}"
        class="text-sm flex items-center gap-3 px-4 py-3 rounded transition-all duration-300 hover:bg-gray-200 {{ request()->routeIs('admin.categories.*') ? 'bg-gray-200 font-medium' : '' }}">
        <i class="fas fa-tags"></i>
        <span>Categories</span>
    </a>

    {{-- Borrowings --}}
    <a href="{{ route('admin.borrowings.index') }}"
        class="text-sm flex items-center gap-3 px-4 py-3 rounded transition-all duration-300 hover:bg-gray-200 {{ request()->routeIs('admin.borrowings.*') ? 'bg-gray-200 font-medium' : '' }}">
        <i class="fas fa-hand-holding"></i>
        <span>Borrowings</span>
    </a>

    {{-- Authors --}}
    <a href="{{ route('admin.authors.index') }}"
        class="text-sm flex items-center gap-3 px-4 py-3 rounded transition-all duration-300 hover:bg-gray-200 {{ request()->routeIs('admin.authors.*') ? 'bg-gray-200 font-medium' : '' }}">
        <i class="fas fa-pen-nib"></i>
        <span>Authors</span>
    </a>

    {{-- Logout --}}
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="inline">
        @csrf
        <button type="submit"
            class="text-sm flex items-center gap-3 px-4 py-3 mt-4 rounded transition-all duration-300 hover:bg-red-100 text-red-600 w-full text-left">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </button>
    </form>
    <script>
        document.getElementById('logout-form').addEventListener('submit', function(event) {
            event.preventDefault();
            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({})
            }).then(response => {
                if (response.ok) {
                    window.location.href = '/login';
                } else {
                    alert('Logout failed.');
                }
            }).catch(error => {
                alert('Logout failed.');
            });
        });
    </script>
</nav>
