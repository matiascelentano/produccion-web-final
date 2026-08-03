<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class OrderApiController extends Controller
{
    public function index(): JsonResponse
    {
        if (!auth()->check()) {
            return response()->json([
                'message' => 'No autenticado. Iniciá sesión para ver tus pedidos.',
            ], 401);
        }

        $orders = auth()->user()
            ->orders()
            ->with('items.product')
            ->latest()
            ->get();

        return response()->json([
            'data' => $orders->map(fn ($order) => [
                'id' => $order->id,
                'status' => $order->status->value,
                'total' => (float) $order->total,
                'created_at' => $order->created_at->toDateTimeString(),
                'items' => $order->items->map(fn ($item) => [
                    'product' => $item->product?->name,
                    'quantity' => $item->quantity,
                    'unit_price' => (float) $item->unit_price,
                ]),
            ]),
        ], 200);
    }
}