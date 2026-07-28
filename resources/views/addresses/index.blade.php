@extends('layouts.app')

@section('title', 'Mis direcciones')

@section('content')
    <div class="max-w-5xl mx-auto p-4">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-semibold">Mis direcciones</h1>
            <a href="{{ route('cart.index') }}" class="text-blue-600 hover:underline">Volver al carrito</a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
        @endif

        <form action="{{ route('addresses.store') }}" method="POST" class="border rounded p-4 mb-6 bg-white">
            @csrf
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Calle y número</label>
                    <input type="text" name="street" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Ciudad</label>
                    <input type="text" name="city" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Provincia</label>
                    <input type="text" name="province" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Código postal</label>
                    <input type="text" name="postal_code" class="w-full border rounded p-2" required>
                </div>
            </div>
            <button type="submit" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded">Agregar dirección</button>
        </form>

        <div class="space-y-3">
            @forelse ($addresses as $address)
                <div class="border rounded p-4 bg-white">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="font-semibold">{{ $address->street }}</p>
                            <p class="text-sm text-gray-600">{{ $address->city }}, {{ $address->province }} · CP {{ $address->postal_code }}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            @if ($address->is_default)
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded text-sm">Activa</span>
                            @endif
                            <form action="{{ route('addresses.update', $address) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="is_default" value="1">
                                <button type="submit" class="border px-3 py-1 rounded text-sm">
                                    {{ $address->is_default ? 'Activa' : 'Usar como activa' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-gray-600">Todavía no agregaste ninguna dirección.</p>
            @endforelse
        </div>
    </div>
@endsection
