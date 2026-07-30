@extends('layouts.admin')

@section('title', 'Productos')

@section('content')
    <div class="p-6">
        @if (session('success'))
            <p class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</p>
        @endif

        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-semibold">Productos</h1>
            <a href="{{ route('admin.products.create') }}" class="bg-gray-900 text-white px-4 py-2 rounded">
                Nuevo producto
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="p-3">Imagen</th>
                        <th class="p-3">Nombre</th>
                        <th class="p-3">Marca</th>
                        <th class="p-3">Precio</th>
                        <th class="p-3">Stock</th>
                        <th class="p-3">Activo</th>
                        <th class="p-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr class="border-b last:border-b-0">
                            <td class="p-3">
                                <img src="{{ $product->primaryImage?->url ?? asset('images/product-placeholder.png') }}"
                                     class="w-12 h-12 object-cover rounded">
                            </td>
                            <td class="p-3 font-medium">{{ $product->name }}</td>
                            <td class="p-3 text-gray-600">{{ $product->brand?->name ?? '—' }}</td>
                            <td class="p-3">{{ $product->price_formatted }}</td>
                            <td class="p-3">{{ $product->stock }}</td>
                            <td class="p-3">
                                @if ($product->active)
                                    <span class="text-green-600 text-sm">Sí</span>
                                @else
                                    <span class="text-gray-400 text-sm">No</span>
                                @endif
                            </td>
                            <td class="p-3 flex gap-2">
                                <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-600 text-sm">Editar</a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('¿Eliminar este producto?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 text-sm">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $products->links() }}</div>
    </div>
@endsection