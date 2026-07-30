@extends('layouts.admin')

@section('title', 'Editar categoría')

@section('content')
    <div class="p-6 max-w-lg">
        <h1 class="text-2xl font-semibold mb-6">Editar categoría</h1>

        <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="space-y-4 bg-white p-6 rounded-xl shadow-sm">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-medium mb-1">Nombre</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block font-medium mb-1">Slug</label>
                <input type="text" name="slug" value="{{ old('slug', $category->slug) }}" class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block font-medium mb-1">Descripción</label>
                <textarea name="description" rows="3" class="w-full border rounded p-2">{{ old('description', $category->description) }}</textarea>
            </div>

            <button type="submit" class="bg-gray-900 text-white px-4 py-2 rounded">Guardar cambios</button>
        </form>
    </div>
@endsection