@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto p-4">
        <h1 class="text-2xl font-semibold mb-4">Mi wishlist</h1>

        @if ($products->isEmpty())
            <p>No tienes productos guardados en tu wishlist.</p>
        @else
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($products as $product)
                    <div class="border rounded-lg p-4">
                        <a href="{{ route('products.show', $product) }}">
                            <img src="{{ $product->primaryImage?->url ?? asset('images/product-placeholder.png') }}" alt="{{ $product->name }}" class="w-full h-40 object-cover rounded">
                            <h2 class="mt-2 font-semibold">{{ $product->name }}</h2>
                        </a>
                        <p class="text-gray-600">{{ $product->price_formatted }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
