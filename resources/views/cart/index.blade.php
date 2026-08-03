@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto p-4">
        <h1 class="text-2xl font-semibold mb-4">Tu carrito</h1>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (blank($cart) || $cart->items->isEmpty())
            <p>No tienes productos en el carrito aún.</p>
        @else
            <div class="space-y-4">
                @foreach ($cart->items as $item)
                    <div class="border rounded p-4 flex gap-4 items-center">
                        <img src="{{ $item->product->primaryImage?->url ?? asset('images/product-placeholder.png') }}" alt="{{ $item->product->name }}" class="w-24 h-24 object-cover rounded">
                        <div class="flex-1">
                            <h2 class="font-semibold">{{ $item->product->name }}</h2>
                            <p>Cantidad: {{ $item->quantity }}</p>
                            <p>Precio: {{ $item->product->price_formatted }}</p>
                        </div>
                        <div class="font-semibold">
                            {{ '$' . number_format($item->quantity * $item->product->price, 2, ',', '.') }}
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        @if (!blank($cart) && $cart->items->isNotEmpty())
            <div class="mt-6 border-t pt-4 text-gray-800 ">
                <div class="grid lg:grid-cols-[1.2fr_0.8fr] gap-6">
                    <div class="border rounded-xl p-4 bg-gray-50">
                        <div class="flex items-center justify-between mb-3">
                            <h2 class="text-xl font-semibold">Envío</h2>
                            <a href="{{ route('addresses.index') }}" class="text-sm text-blue-600 hover:underline">Gestionar direcciones</a>
                        </div>

                        <div class="text-sm text-gray-600 mb-3">
                            <p class="font-medium text-gray-800">Dirección activa</p>
                            @php
                                $activeAddress = auth()->user()->addresses()->where('is_default', true)->first();
                            @endphp
                            @if ($activeAddress)
                                <p class="mt-1">{{ $activeAddress->street }}</p>
                                <p>{{ $activeAddress->city }}, {{ $activeAddress->province }}</p>
                                <p>CP {{ $activeAddress->postal_code }}</p>
                            @else
                                <p class="mt-1">Sin dirección seleccionada</p>
                            @endif
                        </div>

                        <a href="{{ route('orders.checkoutCart') }}" class="w-full bg-green-600 text-white px-6 py-2 rounded font-medium inline-block text-center">
                            Finalizar compra
                        </a>
                    </div>

                    <div class="border rounded-xl p-4 bg-white shadow-sm">
                        <h2 class="text-xl font-semibold mb-3">Resumen</h2>
                        <div class="flex justify-between text-lg text-gray-600">
                            <span>Subtotal</span>
                            <span>{{ '$' . number_format($cart->total, 2, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-lg text-gray-600 mt-2">
                            <span>Envío</span>
                            <span>Gratis</span>
                        </div>
                        <div class="border-t mt-3 pt-3 flex justify-between font-semibold text-xl">
                            <span>Total</span>
                            <span>{{ '$' . number_format($cart->total, 2, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
