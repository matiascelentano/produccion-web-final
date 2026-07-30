<?php
namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items.product', 'user', 'address');

        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => ['required', 'string'],
        ]);

        $nuevoEstado = OrderStatus::from($request->status);

        if (!$order->status->puedeCambiarA($nuevoEstado)) {
            return back()->withErrors(['status' => 'Esa transición de estado no está permitida.']);
        }

        $order->update(['status' => $nuevoEstado]);

        return redirect()->route('admin.orders.show', $order)->with('success', 'Estado actualizado correctamente.');
    }
}