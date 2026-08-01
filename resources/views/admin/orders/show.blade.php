@extends('layouts.admin')

@section('title', "Pedido #{$order->id}")

@section('content')
    <div class="p-6 max-w-2xl">
        @if (session('success'))
            <p class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</p>
        @endif

        <h1 class="text-2xl font-semibold mb-2 text-white">Pedido #{{ $order->id }}</h1>
        <p class="text-gray-300 mb-4">Cliente: {{ $order->user?->name }} ({{ $order->user?->email }})</p>

        <div class="bg-white p-6 rounded-xl shadow-sm mb-6">
            <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="flex items-center gap-3">
                @csrf @method('PUT')
                <label class="font-medium">Estado:</label>
                <select name="status" class="border rounded p-2">
                    @foreach (\App\Enums\OrderStatus::cases() as $status)
                        <option value="{{ $status->value }}" @selected($order->status === $status)>{{ $status->label() }}</option>
                    @endforeach
                </select>
                <button type="submit" class="bg-gray-900 text-white px-4 py-2 rounded">Actualizar</button>
            </form>
            @error('status') <p class="text-red-500 text-sm mt-2">{{ $message }}</p> @enderror
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="font-semibold mb-4">Productos</h2>
            @foreach ($order->items as $item)
                <div class="flex justify-between border-b py-2 last:border-b-0">
                    <span>{{ $item->product->name }} × {{ $item->quantity }}</span>
                    <span>${{ number_format($item->quantity * $item->unit_price, 2, ',', '.') }}</span>
                </div>
            @endforeach
            <div class="flex justify-between font-bold pt-3">
                <span>Total</span>
                <span>${{ number_format($order->total, 2, ',', '.') }}</span>
            </div>
        </div>
    </div>
@endsection