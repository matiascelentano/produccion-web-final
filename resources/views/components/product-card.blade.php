{{-- resources/views/components/product-card.blade.php --}}
<div class="border rounded-lg p-4 hover:shadow-md transition">
    <a href="{{ route('products.show', $product) }}">
        <img
            src="{{ $product->primaryImage?->url ?? asset('images/product-placeholder.png') }}"
            alt="{{ $product->name }}"
            class="w-full h-48 object-cover rounded"
        >

        <h3 class="mt-2 font-semibold">{{ $product->name }}</h3>
        <p class="text-gray-600">{{ $product->price_formatted }}</p>
    </a>

    <div class="mt-2">
        @guest
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('login') }}" class="bg-green-600 text-white px-3 py-1 rounded text-sm">
                    Comprar
                </a>
                <a href="{{ route('login') }}" class="bg-blue-600 text-white px-3 py-1 rounded text-sm">
                    Agregar al carrito
                </a>
                <a href="{{ route('login') }}" class="border px-3 py-1 rounded text-sm">
                    ♡ Wishlist
                </a>
            </div>
        @else
            @php
                $inCart = auth()->check() && auth()->user()->cart?->items()->where('product_id', $product->id)->exists();
                $inWishlist = auth()->check() && auth()->user()->wishlist()->where('products.id', $product->id)->exists();
            @endphp

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('orders.checkoutSingle', $product) }}" class="bg-green-600 text-white px-3 py-1 rounded text-sm">
                    Comprar
                </a>

                @if ($inCart)
                    <form action="{{ route('cart.destroy') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded text-sm">
                            Remover del carrito
                        </button>
                    </form>
                @else
                    <form action="{{ route('cart.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded text-sm">
                            Agregar al carrito
                        </button>
                    </form>
                @endif

                @if ($inWishlist)
                    <form action="{{ route('wishlist.destroy') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" class="bg-pink-600 text-white px-3 py-1 rounded text-sm">
                            ❤ Wishlist
                        </button>
                    </form>
                @else
                    <form action="{{ route('wishlist.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" class="border px-3 py-1 rounded text-sm">
                            ♡ Wishlist
                        </button>
                    </form>
                @endif
            </div>
        @endguest
    </div>
</div>