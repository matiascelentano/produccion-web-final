@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-semibold">Panel de administración</h1>
                <p class="text-gray-600">Resumen general del negocio</p>
            </div>
        </div>

        <div class="grid md:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
            <div class="border rounded-xl p-4 bg-white shadow-sm">
                <p class="text-sm text-gray-500">Productos</p>
                <p class="text-2xl font-semibold">{{ $stats['products'] }}</p>
            </div>
            <div class="border rounded-xl p-4 bg-white shadow-sm">
                <p class="text-sm text-gray-500">Pedidos</p>
                <p class="text-2xl font-semibold">{{ $stats['orders'] }}</p>
            </div>
            <div class="border rounded-xl p-4 bg-white shadow-sm">
                <p class="text-sm text-gray-500">Usuarios</p>
                <p class="text-2xl font-semibold">{{ $stats['users'] }}</p>
            </div>
            <div class="border rounded-xl p-4 bg-white shadow-sm">
                <p class="text-sm text-gray-500">Pedidos pendientes</p>
                <p class="text-2xl font-semibold">{{ $stats['pending_orders'] }}</p>
            </div>
        </div>

        <div class="grid lg:grid-cols-2 gap-6">
            <div class="border rounded-xl p-4 bg-white shadow-sm">
                <h2 class="text-lg font-semibold mb-4">Últimos pedidos</h2>
                @if ($recentOrders->isEmpty())
                    <p class="text-gray-500">No hay pedidos recientes.</p>
                @else
                    <div class="space-y-3">
                        @foreach ($recentOrders as $order)
                            <div class="flex items-center justify-between border-b pb-2 last:border-b-0">
                                <div>
                                    <p class="font-medium">#{{ $order->id }} - {{ $order->user?->name ?? 'Sin usuario' }}</p>
                                    <p class="text-sm text-gray-500">{{ $order->status->label() }}</p>
                                </div>
                                <span class="text-sm font-semibold">${{ number_format($order->total, 2, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="border rounded-xl p-4 bg-white shadow-sm">
                <h2 class="text-lg font-semibold mb-4">Productos con poco stock</h2>
                @if ($lowStockProducts->isEmpty())
                    <p class="text-gray-500">No hay productos con stock bajo.</p>
                @else
                    <div class="space-y-3">
                        @foreach ($lowStockProducts as $product)
                            <div class="flex items-center justify-between border-b pb-2 last:border-b-0">
                                <div>
                                    <p class="font-medium">{{ $product->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $product->brand?->name ?? 'Sin marca' }}</p>
                                </div>
                                <span class="text-sm font-semibold">Stock: {{ $product->stock }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
