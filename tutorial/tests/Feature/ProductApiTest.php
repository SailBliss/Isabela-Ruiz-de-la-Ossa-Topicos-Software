<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_v1_returns_products_and_a_single_product(): void
    {
        $product = Product::factory()->create(['name' => 'Tablet', 'price' => 120]);

        $this->getJson('/api/products')->assertOk()->assertJsonFragment(['name' => 'Tablet']);
        $this->getJson('/api/products/'.$product->id)->assertOk()->assertJsonFragment(['id' => $product->id]);
    }

    public function test_resource_versions_and_paginated_collection_are_available(): void
    {
        Product::factory(6)->create();

        $this->getJson('/api/v2/products')->assertOk()->assertJsonPath('data.0.id', 1);
        $this->getJson('/api/v3/products')->assertOk()->assertJsonPath('additionalData.storeName', 'Mega Store');
        $this->getJson('/api/v3/products/paginate?page=2')
            ->assertOk()
            ->assertJsonPath('meta.current_page', 2)
            ->assertJsonCount(1, 'data');
    }

    public function test_api_can_create_a_product_with_validation(): void
    {
        $this->postJson('/api/products', ['name' => 'Camera', 'price' => 75.50])
            ->assertCreated()
            ->assertJsonFragment(['name' => 'Camera']);

        $this->assertDatabaseHas('products', ['name' => 'Camera', 'price' => 75.5]);
        $this->postJson('/api/products', ['name' => '', 'price' => -1])->assertUnprocessable();
    }

    public function test_v2_resource_can_create_a_product(): void
    {
        $this->postJson('/api/v2/products', ['name' => 'Speaker', 'price' => 99])
            ->assertCreated()
            ->assertJsonPath('data.name', 'Speaker')
            ->assertJsonMissingPath('data.created_at');
    }

    public function test_missing_product_returns_json_404(): void
    {
        $this->getJson('/api/products/999999')->assertNotFound();
    }

    public function test_install_api_registers_sanctum_protected_user_route(): void
    {
        $this->getJson('/api/user')->assertUnauthorized();
    }
}
