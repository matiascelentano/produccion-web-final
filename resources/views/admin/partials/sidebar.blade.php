<aside
    id="admin-sidebar"
    class="fixed inset-y-0 left-0 z-50 w-64 min-h-screen -translate-x-full overflow-y-auto bg-gray-900 text-white p-4 transition-transform duration-300 ease-out lg:static lg:translate-x-0 lg:z-auto"
>
    <div class="flex items-center justify-between mb-6 lg:block">
        <h2 class="text-xl font-semibold">Admin</h2>
        <button type="button" onclick="toggleAdminSidebar()" class="lg:hidden p-1 rounded hover:bg-gray-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <nav class="space-y-2">
        <a href="{{ route('admin.dashboard') }}" class="block rounded px-3 py-2 hover:bg-gray-800">Dashboard</a>
        <a href="{{ route('admin.products.index') }}" class="block rounded px-3 py-2 hover:bg-gray-800">Productos</a>
        <a href="{{ route('admin.categories.index') }}" class="block rounded px-3 py-2 hover:bg-gray-800">Categorías</a>
        <a href="{{ route('admin.brands.index') }}" class="block rounded px-3 py-2 hover:bg-gray-800">Marcas</a>
        <a href="{{ route('admin.orders.index') }}" class="block rounded px-3 py-2 hover:bg-gray-800">Pedidos</a>
        <a href="{{ route('products.index') }}" class="block rounded px-3 py-2 hover:bg-gray-800 mt-4 border-t border-gray-700 pt-4">Ver tienda</a>
    </nav>
</aside>