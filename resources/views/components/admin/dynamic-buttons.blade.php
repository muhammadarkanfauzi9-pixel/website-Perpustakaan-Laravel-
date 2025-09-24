{{-- Dynamic Admin Buttons Component --}}
<div id="dynamic-buttons" class="flex items-center space-x-2">
    {{-- Add New Button --}}
    <button id="btn-add-new" class="hidden dynamic-button bg-blue-500 hover:bg-blue-600 text-white rounded-full w-10 h-10 flex items-center justify-center relative" data-tooltip="Add New">
        <i class="fas fa-plus text-sm"></i>
    </button>

    {{-- Export Button --}}
    <button id="btn-export" class="hidden dynamic-button bg-green-500 hover:bg-green-600 text-white rounded-full w-10 h-10 flex items-center justify-center relative" data-tooltip="Export Data">
        <i class="fas fa-download text-sm"></i>
    </button>

    {{-- Import Button --}}
    <button id="btn-import" class="hidden dynamic-button bg-purple-500 hover:bg-purple-600 text-white rounded-full w-10 h-10 flex items-center justify-center relative" data-tooltip="Import Data">
        <i class="fas fa-upload text-sm"></i>
    </button>

    {{-- Refresh Button --}}
    <button id="btn-refresh" class="hidden dynamic-button bg-gray-500 hover:bg-gray-600 text-white rounded-full w-10 h-10 flex items-center justify-center relative" data-tooltip="Refresh">
        <i class="fas fa-sync-alt text-sm"></i>
    </button>

    {{-- Settings Button --}}
    <button id="btn-settings" class="hidden dynamic-button bg-indigo-500 hover:bg-indigo-600 text-white rounded-full w-10 h-10 flex items-center justify-center relative" data-tooltip="Settings">
        <i class="fas fa-cog text-sm"></i>
    </button>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dynamicButtons = document.getElementById('dynamic-buttons');
    const btnAddNew = document.getElementById('btn-add-new');
    const btnExport = document.getElementById('btn-export');
    const btnImport = document.getElementById('btn-import');
    const btnRefresh = document.getElementById('btn-refresh');
    const btnSettings = document.getElementById('btn-settings');

    // Function to show/hide buttons based on current page
    function updateButtonsVisibility() {
        const currentPath = window.location.pathname;

        // Reset all buttons to hidden
        btnAddNew.classList.add('hidden');
        btnExport.classList.add('hidden');
        btnImport.classList.add('hidden');
        btnRefresh.classList.add('hidden');
        btnSettings.classList.add('hidden');

        // Show relevant buttons based on current page
        if (currentPath.includes('/admin/authors')) {
            btnAddNew.classList.remove('hidden');
            btnExport.classList.remove('hidden');
            btnRefresh.classList.remove('hidden');
        } else if (currentPath.includes('/admin/books')) {
            btnAddNew.classList.remove('hidden');
            btnExport.classList.remove('hidden');
            btnImport.classList.remove('hidden');
            btnRefresh.classList.remove('hidden');
        } else if (currentPath.includes('/admin/categories')) {
            btnAddNew.classList.remove('hidden');
            btnExport.classList.remove('hidden');
            btnRefresh.classList.remove('hidden');
        } else if (currentPath.includes('/admin/publishers')) {
            btnAddNew.classList.remove('hidden');
            btnExport.classList.remove('hidden');
            btnRefresh.classList.remove('hidden');
        } else if (currentPath.includes('/admin/shelves')) {
            btnAddNew.classList.remove('hidden');
            btnExport.classList.remove('hidden');
            btnRefresh.classList.remove('hidden');
        } else if (currentPath.includes('/admin/users')) {
            btnAddNew.classList.remove('hidden');
            btnExport.classList.remove('hidden');
            btnRefresh.classList.remove('hidden');
        } else if (currentPath.includes('/admin/borrowings')) {
            btnAddNew.classList.remove('hidden');
            btnExport.classList.remove('hidden');
            btnRefresh.classList.remove('hidden');
        } else if (currentPath.includes('/admin/dashboard')) {
            btnRefresh.classList.remove('hidden');
            btnSettings.classList.remove('hidden');
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
