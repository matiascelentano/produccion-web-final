{{-- resources/views/components/product-card.blade.php --}}
<div class="bg-brand-card rounded-lg p-4 transition hover:shadow-[0_0_12px_rgba(111,85,206,0.5)] max-w-xl">
    <a href="{{ route('products.show', $product) }}">
        <img
            src="{{ $product->primaryImage?->url ?? asset('images/product-placeholder.png') }}"
            alt="{{ $product->name }}"
            class="w-full h-48 object-cover rounded"
        >
        <h3 class="mt-2 font-sans text-lg text-black truncate">{{ $product->name }}</h3>
        <p class="text-black/70 font-sans text-base font-medium">{{ $product->price_formatted }}</p>
    </a>

    <div class="mt-2 flex gap-2">
        @guest
            <a href="{{ route('login') }}" aria-label="Comprar" title="Comprar"
               class="p-2.5 rounded-full bg-green-600 text-white transition hover:bg-green-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </a>

            <a href="{{ route('login') }}" aria-label="Agregar al carrito" title="Agregar al carrito"
               class="p-2.5 rounded-full bg-brand-dark text-white transition hover:text-brand-accent hover:bg-black">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </a>

            <a href="{{ route('login') }}" aria-label="Agregar a la wishlist" title="Agregar a la wishlist"
               class="p-2.5 rounded-full bg-brand-accent text-black transition hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 10-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
            </a>
        @else
            @php
                $inCart = auth()->user()->cart?->items()->where('product_id', $product->id)->exists();
                $inWishlist = auth()->user()->wishlist()->where('products.id', $product->id)->exists();
            @endphp

            <a href="{{ route('orders.checkoutSingle', $product) }}" aria-label="Comprar" title="Comprar"
               class="p-2.5 bg-green-600 text-white transition hover:bg-green-700">
                <p>Comprar</p>
            </a>


            @if ($inCart)
                <form action="{{ route('cart.destroy') }}" method="POST">
                    @csrf @method('DELETE')
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button type="submit" aria-label="Remover del carrito" title="Ya está en el carrito — quitar"
                        class="p-2.5 rounded-lg bg-red-600 text-white ring-2 ring-red-300 transition hover:bg-red-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </button>
                </form>
            @else
                <form action="{{ route('cart.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button type="submit" aria-label="Agregar al carrito" title="Agregar al carrito"
                        class="p-2.5 rounded-full bg-brand-dark text-white transition hover:text-brand-accent hover:bg-black">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </button>
                </form>
            @endif

            @if ($inWishlist)
                <form action="{{ route('wishlist.destroy') }}" method="POST">
                    @csrf @method('DELETE')
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button type="submit" aria-label="Quitar de la wishlist" title="Ya está en tu wishlist — quitar"
                        class="p-2.5 rounded-lg bg-pink-600 text-white ring-2 ring-pink-300 transition hover:bg-pink-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                    </button>
                </form>
            @else
                <form action="{{ route('wishlist.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button type="submit" aria-label="Agregar a la wishlist" title="Agregar a la wishlist"
                        class="p-2.5 rounded-full bg-brand-accent text-black transition hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 10-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                </form>
            @endif
        @endguest
    </div>
</div>