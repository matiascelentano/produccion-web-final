@extends('layouts.admin')

@section('title', 'Pedidos')

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-semibold mb-6">Pedidos</h1>
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="p-3">#</th>
                        <th class="p-3">Cliente</th>
                        <th class="p-3">Estado</th>
                        <th class="p-3">Total</th>
                        <th class="p-3">Fecha</th>
                        <th class="p-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr class="border-b last:border-b-0">
                            <td class="p-3">#{{ $order->id }}</td>
                            <td class="p-3">{{ $order->user?->name ?? 'Sin usuario' }}</td>
                            <td class="p-3">{{ $order->status->label() }}</td>
                            <td class="p-3">${{ number_format($order->total, 2, ',', '.') }}</td>
                            <td class="p-3">{{ $order->created_at->format('d/m/Y') }}</td>
                            <td class="p-3">
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600 text-sm">Ver detalle</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $orders->links() }}</div>
    </div>
@endsection