<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductDetailTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_shows_the_product_detail_page_with_images_and_information(): void
    {
        $product = Product::factory()->create([
            'name' => 'Producto de prueba',
            'description' => 'Una descripción de prueba',
            'price' => 129.99,
        ]);

        ProductImage::factory()->create([
            'product_id' => $product->id,
            'path' => 'https://example.com/imagen.jpg',
            'is_primary' => true,
        ]);

        $response = $this->get(route('products.show', $product));

        $response->assertOk();
        $response->assertSee('Producto de prueba');
        $response->assertSee('Una descripción de prueba');
        $response->assertSee('$129,99');
        $response->assertSee('https://example.com/imagen.jpg');
    }
}
