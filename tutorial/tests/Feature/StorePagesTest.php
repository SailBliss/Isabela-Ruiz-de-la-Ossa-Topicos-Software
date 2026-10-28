<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;

class StorePagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_are_available(): void
    {
        $this->get('/')->assertOk()->assertSee('Welcome to the application');
        $this->get('/about')->assertOk()->assertSee('About us');
        $this->get('/contact')->assertOk()->assertSee('Creator information');
    }

    public function test_products_can_be_listed_and_viewed(): void
    {
        Product::factory()->create(['name' => 'Chromecast', 'price' => 49]);
        Product::factory()->create(['name' => 'Television', 'price' => 499.99]);

        $this->get('/products')->assertOk()->assertSee('Chromecast');
        $product = Product::query()->where('name', 'Television')->firstOrFail();
        $this->get('/products/'.$product->id)->assertOk()->assertSee('Price: $499.99');
    }

    public function test_invalid_product_redirects_home(): void
    {
        $this->get('/products/999999')->assertRedirect(route('home.index'));
    }

    public function test_product_requires_a_name_and_positive_numeric_price(): void
    {
        $this->from('/products/create')->post('/products/save', [
            'name' => '',
            'price' => 0,
        ])->assertRedirect('/products/create')->assertSessionHasErrors(['name', 'price']);

        $this->assertDatabaseCount('products', 0);
    }

    public function test_valid_product_displays_success_message(): void
    {
        $this->post('/products/save', [
            'name' => 'Keyboard',
            'price' => 25.50,
        ])->assertOk()->assertSee('Product created successfully!')->assertSee('Keyboard');

        $this->assertDatabaseHas('products', ['name' => 'Keyboard', 'price' => 25.5]);
    }
}
