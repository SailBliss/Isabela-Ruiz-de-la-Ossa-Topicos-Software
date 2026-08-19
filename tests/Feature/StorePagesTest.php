<?php

namespace Tests\Feature;

use Tests\TestCase;

class StorePagesTest extends TestCase
{
    public function test_public_pages_are_available(): void
    {
        $this->get('/')->assertOk()->assertSee('Welcome to the application');
        $this->get('/about')->assertOk()->assertSee('About us');
        $this->get('/contact')->assertOk()->assertSee('Creator information');
    }

    public function test_products_can_be_listed_and_viewed(): void
    {
        $this->get('/products')->assertOk()->assertSee('Chromecast');
        $this->get('/products/1')->assertOk()->assertSee('Price: $499.99');
    }

    public function test_invalid_product_redirects_home(): void
    {
        $this->get('/products/100')->assertRedirect(route('home.index'));
    }

    public function test_product_requires_a_name_and_positive_numeric_price(): void
    {
        $this->from('/products/create')->post('/products/save', [
            'name' => '',
            'price' => 0,
        ])->assertRedirect('/products/create')->assertSessionHasErrors(['name', 'price']);
    }

    public function test_valid_product_displays_success_message(): void
    {
        $this->post('/products/save', [
            'name' => 'Keyboard',
            'price' => 25.50,
        ])->assertOk()->assertSee('Product created successfully!')->assertSee('Keyboard');
    }
}
