<header class="bg-white border-b border-b-gray-200 shadow-md px-4 py-3 flex justify-between items-center md:px-8">
    <div class="font-semibold">Admin Library</div>
    <button class="lg:hidden rounded-md focus:outline-none" id="menuButton">
        <i class="fas fa-bars"></i>
    </button>
    <div class="hidden lg:flex lg:items-center lg:gap-4">
        <p class="font-medium text-sm">{{ Auth::user()->name }}</p>
        <div class="flex items-center justify-center w-10 h-10 rounded-full bg-gray-200">
            <span class="font-semibold">{{ substr(Auth::user()->name, 0, 1) }}</span>
        </div>
    </div>
</header>