{{-- resources/views/components/header.blade.php --}}
<header class="border-b bg-white sticky top-0 z-10 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 py-3">
        <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">

            {{-- Fila superior: logo, buscador, y en mobile los iconos de carrito + menú --}}
            <div class="flex items-center gap-3 lg:contents">
                <a href="{{ route('home') }}" class="text-xl font-bold shrink-0">
                    Mi Tienda
                </a>

                <form action="{{ route('products.index') }}" method="GET" class="flex-1 lg:max-w-2xl">
                    <input
                        type="text"
                        name="search"
                        placeholder="Buscar productos..."
                        value="{{ request('search') }}"
                        class="w-full border rounded-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                </form>

                {{-- Iconos de mobile: solo visibles debajo de lg --}}
                <div class="flex items-center gap-2 lg:hidden shrink-0">
                    @auth
                        {{-- Icono de carrito --}}
                        <a href="{{ route('cart.index') }}" class="relative p-2 border rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            @if ($cartCount > 0)
                                <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs rounded-full px-1.5">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>

                        {{-- Botón hamburguesa --}}
                        <details class="relative">
                            <summary class="list-none p-2 border rounded-full cursor-pointer flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </summary>

                            <div class="absolute right-0 mt-2 w-56 border rounded-md bg-white shadow-lg divide-y z-20">
                                <div class="px-4 py-2 text-sm text-gray-500">
                                    {{ auth()->user()->name }}
                                </div>

                                @if (auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 font-semibold text-blue-600 hover:bg-gray-50">
                                        Panel Admin
                                    </a>
                                @endif

                                <a href="{{ route('wishlist.index') }}" class="block px-4 py-3 hover:bg-gray-50">
                                    Wishlist
                                </a>

                                <a href="{{ route('orders.index') }}" class="block px-4 py-3 hover:bg-gray-50">
                                    Mis pedidos
                                </a>

                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-3 hover:bg-gray-50">
                                        Cerrar sesión
                                    </button>
                                </form>
                            </div>
                        </details>
                    @else
                        <details class="relative">
                            <summary class="list-none p-2 border rounded-full cursor-pointer flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </summary>

                            <div class="absolute right-0 mt-2 w-48 border rounded-md bg-white shadow-lg divide-y z-20">
                                <a href="{{ route('login') }}" class="block px-4 py-3 hover:bg-gray-50">
                                    Iniciar sesión
                                </a>
                                <a href="{{ route('register') }}" class="block px-4 py-3 hover:bg-gray-50 text-blue-600 font-semibold">
                                    Registrarse
                                </a>
                            </div>
                        </details>
                    @endauth
                </div>
            </div>

            {{-- Nav desktop: igual que siempre, solo visible a partir de lg --}}
            <nav class="hidden lg:flex items-center gap-3 shrink-0 flex-wrap">
                @auth
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="font-semibold text-blue-600">
                            Panel Admin
                        </a>
                    @endif

                    <a href="{{ route('wishlist.index') }}" class="hover:text-blue-600">Wishlist</a>

                    <a href="{{ route('cart.index') }}" class="relative hover:text-blue-600">
                        Carrito
                        @if ($cartCount > 0)
                            <span class="absolute -top-2 -right-3 bg-red-600 text-white text-xs rounded-full px-1.5">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    <a href="{{ route('orders.index') }}" class="hover:text-blue-600">Mis pedidos</a>

                    <span class="text-gray-600">{{ auth()->user()->name }}</span>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="border px-3 py-1 rounded hover:bg-gray-100">
                            Cerrar sesión
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hover:text-blue-600">Iniciar sesión</a>
                    <a href="{{ route('register') }}" class="bg-blue-600 text-white px-3 py-1 rounded">
                        Registrarse
                    </a>
                @endauth
            </nav>
        </div>

        <div class="mt-3 border-t pt-3 flex flex-wrap items-center gap-4 text-sm">
            <a href="{{ route('products.index') }}" class="font-medium hover:text-blue-600">Catálogo</a>

            @php
                $categories = \App\Models\Category::orderBy('name')->get();
                $brands = \App\Models\Brand::orderBy('name')->get();
            @endphp

            <div class="relative group">
                <button class="font-medium hover:text-blue-600">Categorías</button>
                <div class="absolute left-0 top-full mt-2 hidden w-56 rounded-md border bg-white p-2 shadow-lg group-hover:block">
                    @forelse ($categories as $category)
                        <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="block rounded px-3 py-2 hover:bg-gray-50">
                            {{ $category->name }}
                        </a>
                    @empty
                        <span class="block px-3 py-2 text-gray-500">No hay categorías disponibles</span>
                    @endforelse
                </div>
            </div>

            <div class="relative group">
                <button class="font-medium hover:text-blue-600">Marcas</button>
                <div class="absolute left-0 top-full mt-2 hidden w-56 rounded-md border bg-white p-2 shadow-lg group-hover:block">
                    @forelse ($brands as $brand)
                        <a href="{{ route('products.index', ['brand' => $brand->slug]) }}" class="block rounded px-3 py-2 hover:bg-gray-50">
                            {{ $brand->name }}
                        </a>
                    @empty
                        <span class="block px-3 py-2 text-gray-500">No hay marcas disponibles</span>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</header>