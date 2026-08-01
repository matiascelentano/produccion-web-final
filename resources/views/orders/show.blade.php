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
            <div class="border rounded p-4 mb-2 flex justify-between items-center">
                <div>
                    <p class="font-semibold">{{ $item->product->name }}</p>
                    <p class="text-sm text-gray-500">Cantidad: {{ $item->quantity }} × {{ '$' . number_format($item->unit_price, 2, ',', '.') }}</p>
                </div>
                <p class="font-semibold">{{ '$' . number_format($item->quantity * $item->unit_price, 2, ',', '.') }}</p>
            </div>
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