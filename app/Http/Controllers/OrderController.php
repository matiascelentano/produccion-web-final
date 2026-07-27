<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Http\Requests\PurchaseRequest;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $orders = auth()->user()->orders()->with('items.product')->latest()->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order); // requiere la OrderPolicy

        $order->load('items.product');

        return view('orders.show', compact('order'));
    }

    // Compra directa de UN producto ("Comprar ahora")
    public function storeSingle(PurchaseRequest $request, Product $product)
    {
        $quantity = $request->quantity;

        if ($product->stock < $quantity) {
            return back()->withErrors(['stock' => 'No hay stock suficiente para ese producto.']);
        }

        $order = DB::transaction(function () use ($product, $quantity) {
            $order = Order::create([
                'user_id' => auth()->id(),
                'status' => OrderStatus::Pendiente,
                'total' => $product->price * $quantity,
            ]);

            $order->items()->create([
                'product_id' => $product->id,
                'quantity' => $quantity,
                'unit_price' => $product->price,
            ]);

            $product->decrement('stock', $quantity);

            return $order;
        });

        return redirect()->route('orders.show', $order)->with('success', 'Compra realizada con éxito.');
    }

    // Compra de TODO el carrito ("Finalizar compra")
    public function storeFromCart()
    {
        $cart = auth()->user()->cart()->with('items.product')->first();

        if (blank($cart) || $cart->items->isEmpty()) {
            return back()->withErrors(['cart' => 'Tu carrito está vacío.']);
        }

        // Verificar stock de todos los items ANTES de crear nada
        foreach ($cart->items as $item) {
            if ($item->product->stock < $item->quantity) {
                return back()->withErrors([
                    'stock' => "No hay stock suficiente de \"{$item->product->name}\".",
                ]);
            }
        }

        $order = DB::transaction(function () use ($cart) {
            $order = Order::create([
                'user_id' => auth()->id(),
                'status' => OrderStatus::Pendiente,
                'total' => 0,
            ]);

            $total = 0;

            foreach ($cart->items as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->product->price,
                ]);

                $item->product->decrement('stock', $item->quantity);
                $total += $item->quantity * $item->product->price;
            }

            $order->update(['total' => $total]);

            // Vaciar el carrito una vez confirmada la compra
            $cart->items()->delete();

            return $order;
        });

        return redirect()->route('orders.show', $order)->with('success', 'Compra realizada con éxito.');
    }
}