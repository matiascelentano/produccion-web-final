{{-- resources/views/components/header.blade.php --}}
<header class="sticky top-0 z-10">

    {{-- Barra superior: violeta, con logo + buscador + iconos/nav --}}
    <div class="bg-brand-accent px-4 py-3">
        <div class="max-w-7xl mx-auto flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">

            {{-- Logo + buscador + iconos mobile: van juntos en la misma fila, incluso en mobile --}}
            <div class="flex items-center gap-3 lg:contents">
                <a href="{{ route('home') }}" class="font-pixel text-2xl lg:text-3xl text-black shrink-0">
                    Mi Tienda
                </a>

                <form action="{{ route('products.index') }}" method="GET" class="flex-1 lg:max-w-2xl">
                    <input
                        type="text"
                        name="search"
                        placeholder="Buscar productos..."
                        value="{{ request('search') }}"
                        class="w-full rounded-full px-4 py-2 text-base bg-black/20 text-black placeholder-black/60 focus:outline-none focus:ring-2 focus:ring-black/40"
                    >
                </form>

                {{-- Iconos de mobile: solo visibles debajo de lg --}}
                <div class="flex items-center gap-2 lg:hidden shrink-0">
                    @auth
                        <a href="{{ route('cart.index') }}" class="relative p-2.5 border border-black/30 rounded-full text-black">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            @if ($cartCount > 0)
                                <span class="absolute -top-1 -right-1 bg-brand-dark text-white text-sm rounded-full px-1.5">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>

                        <details class="relative">
                            <summary class="list-none p-2.5 border border-black/30 rounded-full cursor-pointer flex items-center justify-center text-black">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </summary>
                            <div class="absolute right-0 mt-2 w-56 rounded-md bg-brand-panel shadow-lg divide-y divide-white/10 z-20 text-base">
                                <div class="px-4 py-3 text-white/60">
                                    {{ auth()->user()->name }}
                                </div>

                                @if (auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 font-semibold text-brand-accent hover:bg-black/30">
                                        Panel Admin
                                    </a>
                                @endif

                                <a href="{{ route('wishlist.index') }}" class="block px-4 py-3 text-white hover:bg-black/30">
                                    Wishlist
                                </a>

                                <a href="{{ route('orders.index') }}" class="block px-4 py-3 text-white hover:bg-black/30">
                                    Mis pedidos
                                </a>

                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-3 text-white hover:bg-black/30">
                                        Cerrar sesión
                                    </button>
                                </form>
                            </div>
                        </details>
                    @else
                        <details class="relative">
                            <summary class="list-none p-2 border border-black/30 rounded-full cursor-pointer flex items-center justify-center text-black">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </summary>

                            <div class="absolute right-0 mt-2 w-48 rounded-md bg-brand-panel shadow-lg divide-y divide-white/10 z-20 text-base">
                                <a href="{{ route('login') }}" class="block px-4 py-3 text-white hover:bg-black/30">
                                    Iniciar sesión
                                </a>
                                <a href="{{ route('register') }}" class="block px-4 py-3 text-brand-accent font-semibold hover:bg-black/30">
                                    Registrarse
                                </a>
                            </div>
                        </details>
                    @endauth
                </div>
            </div>

            {{-- Nav desktop: igual lógica que siempre, solo visible a partir de lg --}}
            <nav class="hidden lg:flex items-center gap-4 shrink-0 flex-wrap text-black text-lg">
                @auth
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="font-semibold text-brand-dark hover:text-white transition">
                            Panel Admin
                        </a>
                    @endif

                    <a href="{{ route('wishlist.index') }}" class="hover:text-white transition">Wishlist</a>

                    <a href="{{ route('cart.index') }}" class="relative hover:text-white transition">
                        Carrito
                        @if ($cartCount > 0)
                            <span class="absolute -top-2 -right-3 bg-brand-dark text-white text-sm rounded-full px-1.5">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    <a href="{{ route('orders.index') }}" class="hover:text-white transition">Mis pedidos</a>

                    <span class="text-black/70">{{ auth()->user()->name }}</span>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-primary !px-3 !py-1 !text-base">
                            Cerrar sesión
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hover:text-white transition">Iniciar sesión</a>
                    <a href="{{ route('register') }}" class="btn-primary !px-3 !py-1 !text-base">
                        Registrarse
                    </a>
                @endauth
            </nav>
        </div>
    </div>

    <div class="bg-brand-panel px-4 py-2">
        <div class="max-w-7xl mx-auto flex flex-wrap items-center gap-2 text-lg lg:text-xl text-white">
            <a href="{{ route('products.index') }}" class="font-medium px-3 py-2.5 rounded hover:bg-black/30 hover:text-brand-accent transition">
                Catálogo
            </a>

            @php
                $categories = \App\Models\Category::orderBy('name')->get();
                $brands = \App\Models\Brand::orderBy('name')->get();
            @endphp

            <details class="group relative" name="dropdown-menu">
                <summary class="list-none flex items-center gap-1.5 font-medium px-3 py-2.5 rounded cursor-pointer hover:bg-black/30 hover:text-brand-accent transition">
                    <span>Categorías</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform duration-200 group-open:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </summary>
                <div class="absolute left-0 top-full mt-1 w-56 rounded-md bg-brand-panel border border-white/10 p-2 shadow-lg z-20 text-base">
                    @forelse ($categories as $category)
                        <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="block rounded px-3 py-3 hover:bg-black/30 hover:text-brand-accent transition">
                            {{ $category->name }}
                        </a>
                    @empty
                        <span class="block px-3 py-3 text-white/50">No hay categorías disponibles</span>
                    @endforelse
                </div>
            </details>

            <details class="group relative" name="dropdown-menu">
                <summary class="list-none flex items-center gap-1.5 font-medium px-3 py-2.5 rounded cursor-pointer hover:bg-black/30 hover:text-brand-accent transition">
                    <span>Marcas</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform duration-200 group-open:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </summary>
                <div class="absolute left-0 top-full mt-1 w-56 rounded-md bg-brand-panel border border-white/10 p-2 shadow-lg z-20 text-base">
                    @forelse ($brands as $brand)
                        <a href="{{ route('products.index', ['brand' => $brand->slug]) }}" class="block rounded px-3 py-3 hover:bg-black/30 hover:text-brand-accent transition">
                            {{ $brand->name }}
                        </a>
                    @empty
                        <span class="block px-3 py-3 text-white/50">No hay marcas disponibles</span>
                    @endforelse
                </div>
            </details>
        </div>
    </div>
</header>