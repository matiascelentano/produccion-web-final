<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_shows_remove_button_after_adding_a_product_to_the_cart(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $this->actingAs($user)
            ->post(route('cart.store'), ['product_id' => $product->id]);

        $this->actingAs($user)
            ->get(route('home'))
            ->assertSee('Remover del carrito');
    }
}
