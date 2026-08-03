<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $products = Product::with(['brand', 'categories', 'primaryImage'])
            ->where('active', true)
            ->paginate(12);

        return response()->json([
            'data' => $products->through(fn (Product $product) => $this->transform($product)),
            'meta' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'total' => $products->total(),
            ],
        ], 200);
    }

    public function show(int $id): JsonResponse
    {
        $product = Product::with(['brand', 'categories', 'images'])->find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Producto no encontrado.',
            ], 404);
        }

        return response()->json([
            'data' => $this->transform($product, detailed: true),
        ], 200);
    }

    private function transform(Product $product, bool $detailed = false): array
    {
        $data = [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'price' => (float) $product->price,
            'stock' => $product->stock,
            'brand' => $product->brand?->name,
            'categories' => $product->categories->pluck('name'),
            'image_url' => $product->primaryImage?->url,
        ];

        if ($detailed) {
            $data['description'] = $product->description;
            $data['images'] = $product->images->pluck('url');
        }

        return $data;
    }
}