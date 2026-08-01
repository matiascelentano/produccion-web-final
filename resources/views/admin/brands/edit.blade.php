@extends('layouts.admin')

@section('title', 'Editar marca')

@section('content')
    <div class="p-6 max-w-lg">
        <h1 class="text-2xl font-semibold mb-6 text-white">Editar marca</h1>
        <form action="{{ route('admin.brands.update', $brand) }}" method="POST" class="space-y-4 bg-white p-6 rounded-xl shadow-sm">
            @csrf
            @method('PUT')
            <div>
                <label class="block font-medium mb-1">Nombre</label>
                <input type="text" name="name" value="{{ old('name', $brand->name) }}" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block font-medium mb-1">Slug</label>
                <input type="text" name="slug" value="{{ old('slug', $brand->slug) }}" class="w-full border rounded p-2">
            </div>
            <button type="submit" class="bg-gray-900 text-white px-4 py-2 rounded">Guardar cambios</button>
        </form>
    </div>
@endsection