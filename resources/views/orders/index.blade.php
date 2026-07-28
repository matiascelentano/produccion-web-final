{{-- resources/views/orders/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Mis pedidos')

@section('content')
    <div class="max-w-5xl mx-auto p-4">
        <h1 class="text-2xl font-semibold mb-4">Mis pedidos</h1>

        @forelse ($orders as $order)
            <a href="{{ route('orders.show', $order) }}" class="block border rounded p-4 mb-3 hover:shadow-md">
                <div class="flex justify-between">
                    <span>Pedido #{{ $order->id }}</span>
                    <span class="font-semibold">{{ $order->status->label() }}</span>
                </div>
                <p class="text-gray-600">{{ '$' . number_format($order->total, 2, ',', '.') }} — {{ $order->created_at->format('d/m/Y') }}</p>
            </a>
        @empty
            <p>Todavía no realizaste ningún pedido.</p>
        @endforelse

        {{ $orders->links() }}
    </div>
@endsection