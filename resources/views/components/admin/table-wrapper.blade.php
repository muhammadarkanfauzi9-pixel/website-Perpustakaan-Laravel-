{{-- Table Wrapper Component with Dynamic Buttons and Pagination --}}
<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    {{-- Dynamic Action Buttons --}}
    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                {{-- Add New Button --}}
                <button id="btn-add-new" class="dynamic-button bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium transition-all duration-200 flex items-center space-x-2" data-tooltip="Add New">
                    <i class="fas fa-plus text-sm"></i>
                    <span>Add New</span>
                </button>

                {{-- Export Button --}}
                <button id="btn-export" class="dynamic-button bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md text-sm font-medium transition-all duration-200 flex items-center space-x-2" data-tooltip="Export Data">
                    <i class="fas fa-download text-sm"></i>
                    <span>Export</span>
                </button>

                {{-- Import Button --}}
                <button id="btn-import" class="dynamic-button bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-md text-sm font-medium transition-all duration-200 flex items-center space-x-2" data-tooltip="Import Data">
                    <i class="fas fa-upload text-sm"></i>
                    <span>Import</span>
                </button>

                {{-- Refresh Button --}}
                <button id="btn-refresh" class="dynamic-button bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-sm font-medium transition-all duration-200 flex items-center space-x-2" data-tooltip="Refresh">
                    <i class="fas fa-sync-alt text-sm"></i>
                    <span>Refresh</span>
                </button>

                {{-- Settings Button --}}
                <button id="btn-settings" class="dynamic-button bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium transition-all duration-200 flex items-center space-x-2" data-tooltip="Settings">
                    <i class="fas fa-cog text-sm"></i>
                    <span>Settings</span>
                </button>
            </div>

            {{-- Page Info --}}
            <div class="text-sm text-gray-600">
                Showing {{ $items->firstItem() ?? 0 }} to {{ $items->lastItem() ?? 0 }} of {{ $items->total() ?? 0 }} results
            </div>
        </div>
    </div>

    {{-- Table Content --}}
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            {{ $slot }}
        </table>
    </div>

    {{-- Pagination --}}
    @if($items->hasPages())
    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700">
                Page {{ $items->currentPage() }} of {{ $items->lastPage() }}
            </div>

            <div class="flex items-center space-x-2">
                {{-- Previous Button --}}
                @if ($items->onFirstPage())
                    <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded-md cursor-not-allowed">
                        « Previous
                    </span>
                @else
                    <a href="{{ $items->previousPageUrl() }}" class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition-colors duration-200">
                        « Previous
                    </a>
                @endif

                {{-- Page Numbers --}}
                <div class="flex items-center space-x-1">
                    @foreach ($items->getUrlRange(1, $items->lastPage()) as $page => $url)
                        @if ($page == $items->currentPage())
                            <span class="px-3 py-2 text-sm text-white bg-blue-500 rounded-md">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition-colors duration-200">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                </div>

                {{-- Next Button --}}
                @if ($items->hasMorePages())
                    <a href="{{ $items->nextPageUrl() }}" class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition-colors duration-200">
                        Next »
                    </a>
                @else
                    <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded-md cursor-not-allowed">
                        Next »
                    </span>
                @endif
            </div>
        </div>
    </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const btnAddNew = document.getElementById('btn-add-new');
    const btnExport = document.getElementById('btn-export');
    const btnImport = document.getElementById('btn-import');
    const btnRefresh = document.getElementById('btn-refresh');
    const btnSettings = document.getElementById('btn-settings');

    // Function to show/hide buttons based on current page
    function updateButtonsVisibility() {
        const currentPath = window.location.pathname;

        // Hide all buttons first
        if (btnAddNew) btnAddNew.style.display = 'none';
        if (btnExport) btnExport.style.display = 'none';
        if (btnImport) btnImport.style.display = 'none';
        if (btnRefresh) btnRefresh.style.display = 'none';
        if (btnSettings) btnSettings.style.display = 'none';

        // Show relevant buttons based on current page
        if (currentPath.includes('/admin/authors')) {
            if (btnAddNew) btnAddNew.style.display = 'flex';
            if (btnExport) btnExport.style.display = 'flex';
            if (btnRefresh) btnRefresh.style.display = 'flex';
        } else if (currentPath.includes('/admin/books')) {
            if (btnAddNew) btnAddNew.style.display = 'flex';
            if (btnExport) btnExport.style.display = 'flex';
            if (btnImport) btnImport.style.display = 'flex';
            if (btnRefresh) btnRefresh.style.display = 'flex';
        } else if (currentPath.includes('/admin/categories')) {
            if (btnAddNew) btnAddNew.style.display = 'flex';
            if (btnExport) btnExport.style.display = 'flex';
            if (btnRefresh) btnRefresh.style.display = 'flex';
        } else if (currentPath.includes('/admin/publishers')) {
            if (btnAddNew) btnAddNew.style.display = 'flex';
            if (btnExport) btnExport.style.display = 'flex';
            if (btnRefresh) btnRefresh.style.display = 'flex';
        } else if (currentPath.includes('/admin/shelves')) {
            if (btnAddNew) btnAddNew.style.display = 'flex';
            if (btnExport) btnExport.style.display = 'flex';
            if (btnRefresh) btnRefresh.style.display = 'flex';
        } else if (currentPath.includes('/admin/users')) {
            if (btnAddNew) btnAddNew.style.display = 'flex';
            if (btnExport) btnExport.style.display = 'flex';
            if (btnRefresh) btnRefresh.style.display = 'flex';
        } else if (currentPath.includes('/admin/borrowings')) {
            if (btnAddNew) btnAddNew.style.display = 'flex';
            if (btnExport) btnExport.style.display = 'flex';
            if (btnRefresh) btnRefresh.style.display = 'flex';
        } else if (currentPath.includes('/admin/dashboard')) {
            if (btnRefresh) btnRefresh.style.display = 'flex';
            if (btnSettings) btnSettings.style.display = 'flex';
        }
    }

    // Update buttons on page load
    updateButtonsVisibility();

    // Update buttons on navigation (for SPA-like behavior)
    window.addEventListener('popstate', updateButtonsVisibility);

    // Add click event listeners
    if (btnAddNew) {
        btnAddNew.addEventListener('click', function() {
            const currentPath = window.location.pathname;
            if (currentPath.includes('/admin/authors')) {
                window.location.href = '{{ route("admin.authors.create") }}';
            } else if (currentPath.includes('/admin/books')) {
                window.location.href = '{{ route("admin.books.create") }}';
            } else if (currentPath.includes('/admin/categories')) {
                // Categories use modal, trigger modal instead
                document.querySelector('input[name="name"]')?.focus();
            } else if (currentPath.includes('/admin/publishers')) {
                // Publishers use modal, trigger modal instead
                document.querySelector('input[name="name"]')?.focus();
            } else if (currentPath.includes('/admin/shelves')) {
                window.location.href = '{{ route("admin.shelves.create") }}';
            } else if (currentPath.includes('/admin/users')) {
                // Users use modal, trigger modal instead
                document.querySelector('input[name="name"]')?.focus();
            } else if (currentPath.includes('/admin/borrowings')) {
                window.location.href = '{{ route("admin.borrowings.create") }}';
            }
        });
    }

    if (btnExport) {
        btnExport.addEventListener('click', function() {
            // Export functionality - could be CSV, Excel, etc.
            alert('Export functionality will be implemented here');
        });
    }

    if (btnImport) {
        btnImport.addEventListener('click', function() {
            // Import functionality - file upload
            alert('Import functionality will be implemented here');
        });
    }

    if (btnRefresh) {
        btnRefresh.addEventListener('click', function() {
            // Refresh page
            window.location.reload();
        });
    }

    if (btnSettings) {
        btnSettings.addEventListener('click', function() {
            // Go to settings page
            window.location.href = '{{ route("admin.settings.index") }}';
        });
    }
});
</script>
