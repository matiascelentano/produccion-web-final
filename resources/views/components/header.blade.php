{{-- resources/views/components/header.blade.php --}}
<header class="border-b bg-white sticky top-0 z-10">
    <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between gap-4">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="text-xl font-bold shrink-0">
            Mi Tienda
        </a>

        {{-- Barra de búsqueda --}}
        <form action="{{ route('products.index') }}" method="GET" class="flex-1 max-w-md">
            <input
                type="text"
                name="search"
                placeholder="Buscar productos..."
                value="{{ request('search') }}"
                class="w-full border rounded px-3 py-1"
            >
        </form>

        {{-- Navegación --}}
        <nav class="flex items-center gap-4 shrink-0">
            <a href="{{ route('products.index') }}">Catálogo</a>

            {{-- resources/views/components/header.blade.php --}}

            @auth
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="font-semibold text-blue-600">
                        Panel Admin
                    </a>
                @endif

                <a href="{{ route('wishlist.index') }}">Wishlist</a>

                <a href="{{ route('cart.index') }}" class="relative">
                    Carrito
                    @if ($cartCount > 0)
                        <span class="absolute -top-2 -right-3 bg-red-600 text-white text-xs rounded-full px-1.5">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>

                <a href="{{ route('orders.index') }}">Mis pedidos</a>

                <span class="text-gray-600">{{ auth()->user()->name }}</span>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="border px-3 py-1 rounded hover:bg-gray-100">
                        Cerrar sesión
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}">Iniciar sesión</a>
                <a href="{{ route('register') }}" class="bg-blue-600 text-white px-3 py-1 rounded">
                    Registrarse
                </a>
            @endauth
        </nav>
    </div>
</header>