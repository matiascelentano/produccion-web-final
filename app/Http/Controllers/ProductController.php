<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()
            ->where('active', true)
            ->with(['primaryImage', 'brand']);

        // Búsqueda por nombre (viene del buscador del header)
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filtro por categoría
        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Filtro por marca
        if ($request->filled('brand')) {
            $query->whereHas('brand', function ($q) use ($request) {
                $q->where('slug', $request->brand);
            });
        }

        // Orden: precio o antigüedad (RF04)
        match ($request->input('sort')) {
            'price_asc'  => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'oldest'     => $query->orderBy('created_at', 'asc'),
            default      => $query->orderBy('created_at', 'desc'), // más nuevos primero
        };

        $products = $query->paginate(12)->withQueryString();

        $categories = Category::all();
        $brands = Brand::all();

        return view('products.index', compact('products', 'categories', 'brands'));
    }

    public function show(Product $product)
    {
        // Contador simple de vistas (RF15)
        $product->increment('views_count');

        $product->load([
            'images',
            'brand',
            'categories',
            'reviews' => fn ($q) => $q->with('user')->latest(),
        ]);

        // Para saber si mostrar el botón de "dejar reseña" (solo si el cliente ya compró el producto)
        $canReview = auth()->check()
            && auth()->user()->orders()
                ->whereHas('items', fn ($q) => $q->where('product_id', $product->id))
                ->exists();

        return view('products.show', compact('product', 'canReview'));
    }
}
