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
                {{-- Imagen principal --}}
                @if ($mainImage)
                    <div class="w-full h-[420px] rounded-xl border bg-white flex items-center justify-center overflow-hidden">
                        <img id="product-main-image" src="{{ $mainImage->url }}" alt="{{ $product->name }}" class="max-w-full max-h-full object-contain">
                    </div>
                @else
                    <div class="w-full h-[420px] flex items-center justify-center rounded-xl border bg-gray-100 text-gray-500">
                        Sin imagen disponible
                    </div>
                @endif
                
                {{-- Galeria de imagenes --}}
                @if ($images->count() > 1)
                    <div class="mt-4 grid grid-cols-4 gap-3">
                        @foreach ($images as $image)
                            <div class="h-24 w-full rounded border bg-white flex items-center justify-center overflow-hidden cursor-pointer hover:opacity-80 thumbnail-wrapper">
                                <img
                                    src="{{ $image->url }}"
                                    alt="{{ $product->name }}"
                                    class="thumbnail-image max-w-full max-h-full object-contain"
                                    data-image="{{ $image->url }}"
                                >
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div>
                <p class="text-xl uppercase tracking-wide text-blue-600 font-semibold">
                    {{ $product->brand?->name ?? 'Sin marca' }}
                </p>
                <h1 class="text-3xl font-bold mt-2 text-brand-accent">{{ $product->name }}</h1>
                <p class="text-2xl font-semibold text-white-900 mt-4">{{ $product->price_formatted }}</p>

                <div class="mt-3 flex items-center gap-2">
                    <span class="text-sm font-medium {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $product->stock > 0 ? 'En stock' : 'Sin stock' }}
                    </span>
                    <span class="text-sm text-gray-500">({{ $product->stock }} disponibles)</span>
                </div>

                <div class="mt-6 flex gap-3 flex-wrap">
                    @guest
                        <a href="{{ route('login') }}" class="p-2.5 bg-green-600 text-white transition hover:bg-green-700 rounded-md">
                            Comprar ahora
                        </a>
                        <a href="{{ route('login') }}" class="bg-blue-600 text-white px-4 py-2 rounded">
                            Agregar al carrito
                        </a>
                        <a href="{{ route('login') }}" class="border px-4 py-2 rounded">
                            ♡ Wishlist
                        </a>
                    @else
                        <a href="{{ route('orders.checkoutSingle', $product) }}" class="p-2.5 bg-green-600 text-white transition hover:bg-green-700 rounded-md">
                            Comprar ahora
                        </a>

                        @php
                            $inCart = auth()->user()->cart?->items()->where('product_id', $product->id)->exists();
                            $inWishlist = auth()->user()->wishlist()->where('products.id', $product->id)->exists();
                        @endphp


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
                                    class="p-2.5 rounded-full bg-brand-accent text-white transition hover:text-brand-accent hover:bg-black">
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
                                    class="p-2.5 rounded-full bg-brand-accent text-white transition hover:text-brand-accent hover:bg-black">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 10-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </button>
                            </form>
                        @endif
                    @endguest
                </div>

                <div class="mt-8 border-t pt-6">
                    <h2 class="text-xl font-semibold">Descripción</h2>
                    <p class="mt-3 text-gray-200 leading-relaxed">{{ $product->description ?: 'Este producto aún no tiene descripción.' }}</p>
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
            document.querySelectorAll('.thumbnail-wrapper').forEach(function (wrapper) {
                wrapper.addEventListener('click', function () {
                    const thumb = this.querySelector('.thumbnail-image');
                    const mainImage = document.getElementById('product-main-image');
                    if (mainImage && thumb) {
                        mainImage.src = thumb.dataset.image;
                    }
                });
            });
        });
    </script>
@endsection
