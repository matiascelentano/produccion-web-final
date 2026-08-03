<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $user = $request->user();

        $hasPurchased = $user->orders()
            ->whereHas('items', fn ($query) => $query->where('product_id', $product->id))
            ->exists();

        if (! $hasPurchased) {
            abort(403, 'Solo puedes reseñar productos que hayas comprado.');
        }

        $data = $request->validate([
            'rating' => ['required', 'integer', 'between:1,5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        $existingReview = $user->reviews()->where('product_id', $product->id)->first();

        if ($existingReview) {
            $existingReview->update($data);
        } else {
            Review::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'rating' => $data['rating'],
                'comment' => $data['comment'] ?? null,
            ]);
        }

        return back()->with('success', '¡Gracias por tu reseña!');
    }
}
