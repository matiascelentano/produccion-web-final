<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddressManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_and_select_an_active_address(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $this->post(route('addresses.store'), [
            'street' => 'Av. Siempre Viva 742',
            'city' => 'Córdoba',
            'province' => 'Córdoba',
            'postal_code' => '5000',
        ])->assertRedirect(route('addresses.index'));

        $firstAddress = Address::where('user_id', $user->id)->first();
        $this->assertNotNull($firstAddress);
        $this->assertTrue((bool) $firstAddress->is_default);

        $this->post(route('addresses.store'), [
            'street' => 'Belgrano 123',
            'city' => 'Villa Carlos Paz',
            'province' => 'Córdoba',
            'postal_code' => '5152',
        ])->assertRedirect(route('addresses.index'));

        $addresses = Address::where('user_id', $user->id)->get();
        $this->assertCount(2, $addresses);

        $secondAddress = $addresses->where('street', 'Belgrano 123')->first();
        $this->assertNotNull($secondAddress);

        $this->put(route('addresses.update', $secondAddress), [
            'is_default' => true,
        ])->assertRedirect(route('addresses.index'));

        $firstAddress->refresh();
        $secondAddress->refresh();

        $this->assertFalse((bool) $firstAddress->is_default);
        $this->assertTrue((bool) $secondAddress->is_default);
    }
}
