<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WishlistApiController extends Controller
{
    public function index(): JsonResponse
    {
        if (!auth()->check()) {
            return response()->json([
                'message' => 'No autenticado. Iniciá sesión para ver tu wishlist.',
            ], 401);
        }

        $products = auth()->user()->wishlist()->with(['primaryImage', 'brand'])->get();

        return response()->json([
            'data' => $products->map(fn ($product) => [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => (float) $product->price,
                'brand' => $product->brand?->name,
                'image_url' => $product->primaryImage?->url,
            ]),
        ], 200);
    }
}