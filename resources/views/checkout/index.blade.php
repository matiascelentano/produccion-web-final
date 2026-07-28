@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
    <div class="max-w-6xl mx-auto p-4 lg:p-6">
        <h1 class="text-2xl font-semibold mb-4">Finalizar compra</h1>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid lg:grid-cols-[1.2fr_0.8fr] gap-6">
            <form action="{{ $submitRoute }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="quantity" value="{{ $quantity ?? 1 }}">

                <div class="border rounded-xl p-4 bg-white">
                    <h2 class="text-lg font-semibold mb-4">Datos de contacto</h2>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Nombre completo</label>
                            <input type="text" name="customer_name" value="{{ old('customer_name', auth()->user()->name . ' ' . auth()->user()->last_name) }}" class="w-full border rounded p-2" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Teléfono</label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" class="w-full border rounded p-2" required>
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="block text-sm font-medium mb-1">Notas para el pedido</label>
                        <textarea name="notes" rows="3" class="w-full border rounded p-2">{{ old('notes') }}</textarea>
                    </div>
                </div>

                <div class="border rounded-xl p-4 bg-white">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-lg font-semibold">Dirección de envío</h2>
                        <a href="{{ route('addresses.index') }}" class="text-sm text-blue-600 hover:underline">Gestionar direcciones</a>
                    </div>

                    @if ($addresses->isEmpty())
                        <p class="text-sm text-gray-600">No tienes direcciones guardadas. Agrega una antes de continuar.</p>
                    @else
                        <div class="space-y-2">
                            @foreach ($addresses as $address)
                                <label class="flex items-start gap-3 border rounded p-3 cursor-pointer">
                                    <input type="radio" name="address_id" value="{{ $address->id }}" {{ old('address_id', $address->is_default ? $address->id : null) == $address->id ? 'checked' : '' }} required>
                                    <span>
                                        <span class="font-medium">{{ $address->street }}</span><br>
                                        <span class="text-sm text-gray-600">{{ $address->city }}, {{ $address->province }} · CP {{ $address->postal_code }}</span>
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    @endif
                </div>

                <button type="submit" class="w-full bg-green-600 text-white px-6 py-3 rounded font-medium">
                    Confirmar compra
                </button>
            </form>

            <div class="border rounded-xl p-4 bg-gray-50 h-fit">
                <h2 class="text-lg font-semibold mb-3">Resumen</h2>
                @if ($mode === 'single')
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>{{ $product->name }}</span>
                        <span>{{ '$' . number_format($product->price * ($quantity ?? 1), 2, ',', '.') }}</span>
                    </div>
                @else
                    @foreach ($cart->items as $item)
                        <div class="flex justify-between text-sm text-gray-600 mb-2">
                            <span>{{ $item->product->name }} × {{ $item->quantity }}</span>
                            <span>{{ '$' . number_format($item->quantity * $item->product->price, 2, ',', '.') }}</span>
                        </div>
                    @endforeach
                @endif
                <div class="border-t mt-3 pt-3 flex justify-between font-semibold">
                    <span>Total</span>
                    <span>{{ '$' . number_format($total, 2, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection
