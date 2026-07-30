{{-- resources/views/home.blade.php --}}
@extends('layouts.app')

@section('title', 'Inicio')

@section('content')

    <section class="w-full">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-6">
            <img src="{{ asset('images/promo-banner-1.jpg') }}" alt="Promoción" class="rounded-lg w-full object-cover">
            <img src="{{ asset('images/promo-banner-2.jpg') }}" alt="Promoción" class="rounded-lg w-full object-cover">
        </div>
    </section>

    <section class="p-6">
        <h2 class="text-2xl font-bold mb-4">Explorá por categoría</h2>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach ($categories as $category)
                <a href="{{ route('products.index', ['category' => $category->slug]) }}"
                   class="border rounded-lg p-4 text-center hover:shadow-md transition">
                    <p class="font-semibold">{{ $category->name }}</p>
                    <p class="text-sm text-gray-500">{{ $category->products_count }} productos</p>
                </a>
            @endforeach
        </div>
    </section>

    <section class="p-6">
        <h2 class="text-2xl font-bold mb-4">Productos destacados</h2>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-5 lg:grid-cols-3 xl:grid-cols-4 xl:gap-6">
            @foreach ($featuredProducts as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>

        @if ($featuredProducts->isEmpty())
            <p class="text-gray-500">Todavía no hay productos cargados.</p>
        @endif
    </section>

@endsection