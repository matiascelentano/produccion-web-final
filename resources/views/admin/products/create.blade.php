@extends('layouts.admin')

@section('title', 'Nuevo producto')

@section('content')
    <div class="p-6 max-w-2xl">
        <h1 class="text-2xl font-semibold mb-6">Nuevo producto</h1>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 bg-white p-6 rounded-xl shadow-sm">
            @csrf

            <div>
                <label class="block font-medium mb-1">Nombre</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded p-2">
                @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block font-medium mb-1">Descripción</label>
                <textarea name="description" rows="4" class="w-full border rounded p-2">{{ old('description') }}</textarea>
                @error('description') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium mb-1">Precio</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price') }}" class="w-full border rounded p-2">
                    @error('price') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block font-medium mb-1">Stock</label>
                    <input type="number" name="stock" value="{{ old('stock') }}" class="w-full border rounded p-2">
                    @error('stock') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block font-medium mb-1">Marca</label>
                <select name="brand_id" class="w-full border rounded p-2">
                    <option value="">Sin marca</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}" @selected(old('brand_id') == $brand->id)>{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-medium mb-1">Categorías</label>
                @foreach ($categories as $category)
                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                               @checked(collect(old('categories'))->contains($category->id))>
                        {{ $category->name }}
                    </label>
                @endforeach
                @error('categories') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="active" value="1" checked>
                    Producto activo (visible en la tienda)
                </label>
            </div>

            <div>
                <label class="block font-medium mb-1">Imágenes</label>
                <input type="file" name="images[]" multiple accept="image/*" class="w-full border rounded p-2">
                @error('images.*') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="bg-gray-900 text-white px-4 py-2 rounded">Crear producto</button>
        </form>
    </div>
@endsection