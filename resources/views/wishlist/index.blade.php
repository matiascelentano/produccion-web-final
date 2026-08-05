@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto p-4">
        <h1 class="text-2xl font-semibold mb-4">Mi wishlist</h1>

        @if ($products->isEmpty())
            <p>No tienes productos guardados en tu wishlist.</p>
        @else
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($products as $product)
                    <div class="border rounded-lg p-4 flex flex-col gap-3">
                        <a href="{{ route('products.show', $product) }}" class="flex-1">
                            <img src="{{ $product->primaryImage?->url ?? asset('images/product-placeholder.png') }}" alt="{{ $product->name }}" class="w-full h-40 object-cover rounded">
                            <h2 class="mt-2 font-semibold">{{ $product->name }}</h2>
                        </a>
                        <p class="text-gray-600">{{ $product->price_formatted }}</p>

                        <form action="{{ route('wishlist.destroy') }}" method="POST" class="mt-auto">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="w-full rounded bg-red-600 px-3 py-2 text-sm font-semibold text-white hover:bg-red-700 transition" aria-label="Quitar de la wishlist" title="Quitar de la wishlist">
                                Remover de la wishlist
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
