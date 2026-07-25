{{-- resources/views/components/product-card.blade.php --}}
<div class="border rounded-lg p-4 hover:shadow-md transition">
    <a href="{{ route('products.show', $product) }}">
        <img
            src="{{ $product->primaryImage?->url ?? asset('images/product-placeholder.png') }}"
            alt="{{ $product->name }}"
            class="w-full h-48 object-cover rounded"
        >

        <h3 class="mt-2 font-semibold">{{ $product->name }}</h3>
        <p class="text-gray-600">{{ $product->price_formatted }}</p>
    </a>

    <div class="mt-2 flex gap-2">
        <form action="{{ route('cart.store') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded text-sm">
                Agregar al carrito
            </button>
        </form>

        <form action="{{ route('wishlist.store') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <button type="submit" class="border px-3 py-1 rounded text-sm">
                ♡ Wishlist
            </button>
        </form>
    </div>
</div>