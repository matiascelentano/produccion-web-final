<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Http\Requests\PurchaseRequest;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
        if (auth()->id() !== $order->user_id) {
            abort(403, 'No tienes permiso para ver esta orden.');
        }

        $order->load('items.product');

        return view('orders.show', compact('order'));
    }

    public function checkoutSingle(Product $product)
    {
        $addresses = auth()->user()->addresses()->orderByDesc('is_default')->get();
        $quantity = 1;
        $total = $product->price * $quantity;

        return view('checkout.index', [
            'mode' => 'single',
            'product' => $product,
            'quantity' => $quantity,
            'total' => $total,
            'addresses' => $addresses,
            'cart' => null,
            'submitRoute' => route('orders.storeSingle', $product),
        ]);
    }

    public function checkoutCart()
    {
        $cart = auth()->user()->cart()->with('items.product')->first();

        if (blank($cart) || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->withErrors(['cart' => 'Tu carrito está vacío.']);
        }

        $addresses = auth()->user()->addresses()->orderByDesc('is_default')->get();
        $total = $cart->items->sum(fn ($item) => $item->quantity * $item->product->price);

        return view('checkout.index', [
            'mode' => 'cart',
            'product' => null,
            'quantity' => null,
            'total' => $total,
            'addresses' => $addresses,
            'cart' => $cart,
            'submitRoute' => route('orders.storeFromCart'),
        ]);
    }

    // Compra directa de UN producto ("Comprar ahora")
    public function storeSingle(PurchaseRequest $request, Product $product)
    {
        $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
            'customer_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'address_id' => ['required', 'exists:addresses,id'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $quantity = $request->quantity;
        $address = auth()->user()->addresses()->find($request->address_id);

        if (!$address) {
            return back()->withErrors(['address' => 'Agrega y selecciona una dirección antes de comprar.']);
        }

        if ($product->stock < $quantity) {
            return back()->withErrors(['stock' => 'No hay stock suficiente para ese producto.']);
        }

        $order = DB::transaction(function () use ($product, $quantity, $address, $request) {
            $order = Order::create([
                'user_id' => auth()->id(),
                'address_id' => $address->id,
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
    public function storeFromCart(Request $request)
    {
        $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'address_id' => ['required', 'exists:addresses,id'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $cart = auth()->user()->cart()->with('items.product')->first();

        if (blank($cart) || $cart->items->isEmpty()) {
            return back()->withErrors(['cart' => 'Tu carrito está vacío.']);
        }

        $address = auth()->user()->addresses()->find($request->address_id);

        if (!$address) {
            return back()->withErrors(['address' => 'Agrega y selecciona una dirección antes de comprar.']);
        }

        // Verificar stock de todos los items ANTES de crear nada
        foreach ($cart->items as $item) {
            if ($item->product->stock < $item->quantity) {
                return back()->withErrors([
                    'stock' => "No hay stock suficiente de \"{$item->product->name}\".",
                ]);
            }
        }

        $order = DB::transaction(function () use ($cart, $address) {
            $order = Order::create([
                'user_id' => auth()->id(),
                'address_id' => $address->id,
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