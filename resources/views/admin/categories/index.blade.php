@extends('layouts.admin')

@section('title', 'Categorías')

@section('content')
    <div class="p-6">
        @if (session('success'))
            <p class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</p>
        @endif

        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-semibold text-white">Categorías</h1>
            <a href="{{ route('admin.categories.create') }}" class="bg-gray-900 text-white px-4 py-2 rounded">Nueva categoría</a>
        </div>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="p-3">Nombre</th>
                        <th class="p-3">Productos</th>
                        <th class="p-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr class="border-b last:border-b-0">
                            <td class="p-3 font-medium">{{ $category->name }}</td>
                            <td class="p-3">{{ $category->products_count }}</td>
                            <td class="p-3 flex gap-2">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="text-blue-600 text-sm">Editar</a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('¿Eliminar esta categoría?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 text-sm">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $categories->links() }}</div>
    </div>
@endsection