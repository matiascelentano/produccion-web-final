<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $products = auth()->user()->wishlist()->with(['primaryImage', 'brand'])->get();

        return view('wishlist.index', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
        ]);

        auth()->user()->wishlist()->syncWithoutDetaching([$request->product_id]);

        return back()->with('success', 'Producto agregado a tu wishlist.');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
        ]);

        auth()->user()->wishlist()->detach($request->product_id);

        return back()->with('success', 'Producto removido de tu wishlist.');
    }
}
