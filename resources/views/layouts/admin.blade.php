<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>
    <div class="lg:hidden sticky top-0 z-30 flex items-center justify-between bg-gray-900 text-white px-4 py-3">
        <span class="text-lg font-semibold">Admin</span>
        <button type="button" onclick="toggleAdminSidebar()" class="p-2 rounded border border-white/20">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <div
        id="admin-sidebar-overlay"
        class="fixed inset-0 z-40 hidden bg-black/50 lg:hidden"
        onclick="toggleAdminSidebar()"
    ></div>

    <div class="flex">
        @include('admin.partials.sidebar')

        <main class="flex-1 min-w-0">
            @yield('content')
        </main>
    </div>

    <script>
        function toggleAdminSidebar() {
            const sidebar = document.getElementById('admin-sidebar');
            const overlay = document.getElementById('admin-sidebar-overlay');

            if (!sidebar || !overlay) return;

            const isOpening = sidebar.classList.contains('-translate-x-full');

            if (isOpening) {
                overlay.classList.remove('hidden');
                requestAnimationFrame(() => {
                    sidebar.classList.remove('-translate-x-full');
                });
                document.body.classList.add('overflow-hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                document.body.classList.remove('overflow-hidden');
                setTimeout(() => overlay.classList.add('hidden'), 300);
            }
        }
    </script>
</body>
</html>