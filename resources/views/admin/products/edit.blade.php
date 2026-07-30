@extends('layouts.admin')

@section('title', 'Editar producto')

@section('content')
    <div class="p-6 max-w-2xl">
        <h1 class="text-2xl font-semibold mb-6">Editar producto</h1>

        {{-- Imágenes actuales: AHORA FUERA del form principal, cada una con su propio form de borrado --}}
        @if ($product->images->isNotEmpty())
            <div class="mb-4 bg-white p-6 rounded-xl shadow-sm">
                <label class="block font-medium mb-2">Imágenes actuales</label>
                <div class="flex gap-2 flex-wrap">
                    @foreach ($product->images as $image)
                        <div class="relative">
                            <img src="{{ $image->url }}" class="w-20 h-20 object-cover rounded border">
                            <form action="{{ route('admin.product-images.destroy', $image) }}" method="POST"
                                  class="absolute -top-2 -right-2" onsubmit="return confirm('¿Eliminar imagen?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white rounded-full w-5 h-5 text-xs">×</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Form principal de editar producto: ahora sin ningún form anidado adentro --}}
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-4 bg-white p-6 rounded-xl shadow-sm">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-medium mb-1">Nombre</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full border rounded p-2">
                @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block font-medium mb-1">Descripción</label>
                <textarea name="description" rows="4" class="w-full border rounded p-2">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium mb-1">Precio</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" class="w-full border rounded p-2">
                </div>
                <div>
                    <label class="block font-medium mb-1">Stock</label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="w-full border rounded p-2">
                </div>
            </div>

            <div>
                <label class="block font-medium mb-1">Marca</label>
                <select name="brand_id" class="w-full border rounded p-2">
                    <option value="">Sin marca</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}" @selected(old('brand_id', $product->brand_id) == $brand->id)>{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-medium mb-1">Categorías</label>
                @php $productCategoryIds = $product->categories->pluck('id'); @endphp
                @foreach ($categories as $category)
                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                               @checked(collect(old('categories', $productCategoryIds))->contains($category->id))>
                        {{ $category->name }}
                    </label>
                @endforeach
            </div>

            <div>
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="active" value="1" @checked($product->active)>
                    Producto activo
                </label>
            </div>

            <div>
                <label class="block font-medium mb-1">Agregar más imágenes</label>
                <input type="file" name="images[]" multiple accept="image/*" class="w-full border rounded p-2">
            </div>

            <button type="submit" class="bg-gray-900 text-white px-4 py-2 rounded">Guardar cambios</button>
        </form>
    </div>
@endsection