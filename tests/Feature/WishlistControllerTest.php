<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WishlistControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_shows_a_remove_button_in_the_wishlist_page(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $user->wishlist()->attach($product);

        $this->actingAs($user)
            ->get(route('wishlist.index'))
            ->assertSee('Quitar de la wishlist');
    }
}
