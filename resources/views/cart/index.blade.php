@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto p-4">
        <h1 class="text-2xl font-semibold mb-4">Tu carrito</h1>

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
    </div>
@endsection
