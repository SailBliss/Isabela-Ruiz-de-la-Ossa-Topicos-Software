<?php

namespace Tests\Feature;

use Tests\TestCase;

class CartTest extends TestCase
{
    public function test_cart_starts_empty_and_lists_available_products(): void
    {
        $this->get('/cart')
            ->assertOk()
            ->assertSee('Available products')
            ->assertSee('Tv samsung')
            ->assertSee('Iphone')
            ->assertSee('Products in cart')
            ->assertSessionMissing('cart_product_data');
    }

    public function test_product_is_added_to_cart_and_persists_between_requests(): void
    {
        $this->withSession([])
            ->post('/cart/items/121')
            ->assertRedirect();

        $this->get('/cart')
            ->assertOk()
            ->assertSee('Tv samsung')
            ->assertSessionHas('cart_product_data.121', 121);
    }

    public function test_invalid_product_ids_are_not_added(): void
    {
        $this->post('/cart/items/999')->assertNotFound();
        $this->post('/cart/items/not-a-number')->assertNotFound();

        $this->get('/cart')->assertSessionMissing('cart_product_data');
    }

    public function test_cart_can_be_cleared(): void
    {
        $this->withSession(['cart_product_data' => [121 => 121]])
            ->delete('/cart/items')
            ->assertRedirect();

        $this->get('/cart')->assertOk()->assertSessionMissing('cart_product_data');
    }
}
