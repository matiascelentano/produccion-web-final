@extends('layouts.app')

@section('title', 'Catálogo')

@section('content')
    <div class="flex gap-6 p-6">

        {{-- Sidebar de filtros --}}
        <aside class="w-64 shrink-0">
            <form method="GET" action="{{ route('products.index') }}">
                <input type="hidden" name="search" value="{{ request('search') }}">

                <h3 class="font-semibold mb-2">Categorías</h3>
                @foreach ($categories as $category)
                    <label class="block">
                        <input type="radio" name="category" value="{{ $category->slug }}"
                               @checked(request('category') === $category->slug)
                               onchange="this.form.submit()">
                        {{ $category->name }}
                    </label>
                @endforeach

                <h3 class="font-semibold mt-4 mb-2">Marcas</h3>
                @foreach ($brands as $brand)
                    <label class="block">
                        <input type="radio" name="brand" value="{{ $brand->slug }}"
                               @checked(request('brand') === $brand->slug)
                               onchange="this.form.submit()">
                        {{ $brand->name }}
                    </label>
                @endforeach
            </form>
        </aside>

        {{-- Listado --}}
        <div class="flex-1">
            <div class="flex justify-between items-center mb-4">
                <p>{{ $products->total() }} productos encontrados</p>

                <form method="GET" action="{{ route('products.index') }}">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <input type="hidden" name="category" value="{{ request('category') }}">
                    <input type="hidden" name="brand" value="{{ request('brand') }}">

                    <select name="sort" onchange="this.form.submit()">
                        <option value="">Más recientes</option>
                        <option value="price_asc" @selected(request('sort') === 'price_asc')>Menor precio</option>
                        <option value="price_desc" @selected(request('sort') === 'price_desc')>Mayor precio</option>
                        <option value="oldest" @selected(request('sort') === 'oldest')>Más antiguos</option>
                    </select>
                </form>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach ($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>

            @if ($products->isEmpty())
                <p class="text-gray-500">No se encontraron productos con esos filtros.</p>
            @endif

            <div class="mt-6">
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection