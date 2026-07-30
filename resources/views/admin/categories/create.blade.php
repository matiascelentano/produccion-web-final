@extends('layouts.admin')

@section('title', 'Nueva categoría')

@section('content')
    <div class="p-6 max-w-lg">
        <h1 class="text-2xl font-semibold mb-6">Nueva categoría</h1>

        <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4 bg-white p-6 rounded-xl shadow-sm">
            @csrf

            <div>
                <label class="block font-medium mb-1">Nombre</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded p-2">
                @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block font-medium mb-1">Slug</label>
                <input type="text" name="slug" value="{{ old('slug') }}" class="w-full border rounded p-2">
                @error('slug') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block font-medium mb-1">Descripción</label>
                <textarea name="description" rows="3" class="w-full border rounded p-2">{{ old('description') }}</textarea>
            </div>

            <button type="submit" class="bg-gray-900 text-white px-4 py-2 rounded">Crear categoría</button>
        </form>
    </div>
@endsection