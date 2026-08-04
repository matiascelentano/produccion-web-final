<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderDetailTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_items_are_clickable_and_open_the_product_page(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['name' => 'Producto clickeable']);

        $order = Order::create([
            'user_id' => $user->id,
            'status' => 'entregado',
            'total' => 100.00,
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'unit_price' => 100.00,
        ]);

        $response = $this->actingAs($user)->get(route('orders.show', $order));

        $response->assertOk();
        $response->assertSeeHtml('<a href="' . route('products.show', $product) . '" class="block border rounded p-4 mb-2 hover:bg-gray-50 transition">');
    }
}
