<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $cart = auth()->user()->cart()->with('items.product')->first();

        return view('cart.index', [
            'cart' => $cart,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
        ]);

        $cart = $request->user()->cart()->firstOrCreate();

        $item = $cart->items()->where('product_id', $request->product_id)->first();

        if ($item) {
            $item->increment('quantity');
        } else {
            $cart->items()->create([
                'product_id' => $request->product_id,
                'quantity' => 1,
            ]);
        }

        return back()->with('success', 'Producto agregado al carrito.');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
        ]);

        $cart = $request->user()->cart()->first();

        if ($cart) {
            $cart->items()->where('product_id', $request->product_id)->delete();
        }

        return back()->with('success', 'Producto removido del carrito.');
    }
}
