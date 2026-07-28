@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <div class="max-w-7xl mx-auto px-6 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div>
                @php
                    $images = $product->images()->orderBy('order')->get();
                    $mainImage = $images->firstWhere('is_primary', true) ?? $images->first() ?? null;
                @endphp

                @if ($mainImage)
                    <img id="product-main-image" src="{{ $mainImage->url }}" alt="{{ $product->name }}" class="w-full h-[420px] object-cover rounded-xl border">
                @else
                    <div class="w-full h-[420px] flex items-center justify-center rounded-xl border bg-gray-100 text-gray-500">
                        Sin imagen disponible
                    </div>
                @endif

                @if ($images->count() > 1)
                    <div class="mt-4 grid grid-cols-4 gap-3">
                        @foreach ($images as $image)
                            <img
                                src="{{ $image->url }}"
                                alt="{{ $product->name }}"
                                class="thumbnail-image h-24 w-full object-cover rounded border cursor-pointer hover:opacity-80"
                                data-image="{{ $image->url }}"
                            >
                        @endforeach
                    </div>
                @endif
            </div>

            <div>
                <p class="text-sm uppercase tracking-wide text-blue-600 font-semibold">
                    {{ $product->brand?->name ?? 'Sin marca' }}
                </p>
                <h1 class="text-3xl font-bold mt-2">{{ $product->name }}</h1>
                <p class="text-2xl font-semibold text-gray-900 mt-4">{{ $product->price_formatted }}</p>

                <div class="mt-3 flex items-center gap-2">
                    <span class="text-sm font-medium {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $product->stock > 0 ? 'En stock' : 'Sin stock' }}
                    </span>
                    <span class="text-sm text-gray-500">({{ $product->stock }} disponibles)</span>
                </div>

                <div class="mt-6 flex gap-3 flex-wrap">
                    @guest
                        <a href="{{ route('login') }}" class="bg-green-600 text-white px-4 py-2 rounded">
                            Comprar ahora
                        </a>
                        <a href="{{ route('login') }}" class="bg-blue-600 text-white px-4 py-2 rounded">
                            Agregar al carrito
                        </a>
                        <a href="{{ route('login') }}" class="border px-4 py-2 rounded">
                            ♡ Wishlist
                        </a>
                    @else
                        <a href="{{ route('orders.checkoutSingle', $product) }}" class="bg-green-600 text-white px-4 py-2 rounded inline-block">
                            Comprar ahora
                        </a>

                        @php
                            $inCart = auth()->user()->cart?->items()->where('product_id', $product->id)->exists();
                            $inWishlist = auth()->user()->wishlist()->where('products.id', $product->id)->exists();
                        @endphp

                        @if ($inCart)
                            <form action="{{ route('cart.destroy') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">Remover del carrito</button>
                            </form>
                        @else
                            <form action="{{ route('cart.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Agregar al carrito</button>
                            </form>
                        @endif

                        @if ($inWishlist)
                            <form action="{{ route('wishlist.destroy') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="submit" class="bg-pink-600 text-white px-4 py-2 rounded">❤ Wishlist</button>
                            </form>
                        @else
                            <form action="{{ route('wishlist.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="submit" class="border px-4 py-2 rounded">♡ Wishlist</button>
                            </form>
                        @endif
                    @endguest
                </div>

                <div class="mt-8 border-t pt-6">
                    <h2 class="text-xl font-semibold">Descripción</h2>
                    <p class="mt-3 text-gray-700 leading-relaxed">{{ $product->description ?: 'Este producto aún no tiene descripción.' }}</p>
                </div>

                @if ($product->categories->isNotEmpty())
                    <div class="mt-6">
                        <h2 class="text-lg font-semibold">Categorías</h2>
                        <div class="flex flex-wrap gap-2 mt-2">
                            @foreach ($product->categories as $category)
                                <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">{{ $category->name }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.thumbnail-image').forEach(function (thumb) {
                thumb.addEventListener('click', function () {
                    const mainImage = document.getElementById('product-main-image');
                    if (mainImage) {
                        mainImage.src = this.dataset.image;
                    }
                });
            });
        });
    </script>
@endsection
