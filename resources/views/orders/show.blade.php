{{-- resources/views/orders/show.blade.php --}}
@extends('layouts.app')

@section('title', "Pedido #{$order->id}")

@section('content')
    <div class="max-w-3xl mx-auto p-4">
        @if (session('success'))
            <p class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</p>
        @endif

        <h1 class="text-2xl font-semibold mb-2">Pedido #{{ $order->id }}</h1>
        <p class="text-gray-600 mb-4">Estado: <span class="font-semibold">{{ $order->status->label() }}</span></p>

        @foreach ($order->items as $item)
            <a href="{{ route('products.show', $item->product) }}" class="block border rounded p-4 mb-2 bg-white hover:bg-black transition">
                <div class="flex justify-between items-start gap-4">
                    <div class="flex items-center gap-3">
                        @php
                            $thumbnail = $item->product->primaryImage?->url ?? $item->product->images()->first()?->url ?? null;
                        @endphp

                        @if ($thumbnail)
                            <img src="{{ $thumbnail }}" alt="{{ $item->product->name }}" class="h-16 w-16 rounded object-cover border">
                        @else
                            <div class="h-16 w-16 rounded border bg-gray-100 flex items-center justify-center text-xs text-gray-500">
                                Sin foto
                            </div>
                        @endif

                        <div>
                            <p class="font-semibold text-blue-600 hover:underline">{{ $item->product->name }}</p>
                            <p class="text-sm text-gray-500">Cantidad: {{ $item->quantity }} × {{ '$' . number_format($item->unit_price, 2, ',', '.') }}</p>
                        </div>
                    </div>
                    <p class="font-semibold text-gray-700">{{ '$' . number_format($item->quantity * $item->unit_price, 2, ',', '.') }}</p>
                </div>
            </a>
        @endforeach

        @if ($order->address)
            <div class="mt-4 border rounded p-4 bg-gray-50 text-gray-800">
                <h2 class="font-semibold mb-2">Dirección de envío</h2>
                <p>{{ $order->address->street }}</p>
                <p>{{ $order->address->city }}, {{ $order->address->province }}</p>
                <p>CP {{ $order->address->postal_code }}</p>
            </div>
        @endif

        <div class="mt-4 text-right text-xl font-bold">
            Total: {{ '$' . number_format($order->total, 2, ',', '.') }}
        </div>
    </div>
@endsection