<?php

namespace Tests\Feature\Products;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductIndexTest extends TestCase
{
    public function test_it_shows_a_collection_of_product()
    {
        $product = Product::factory()->create();

        $this->json('GET', 'api/products')
            ->assertJsonFragment([
                'id' => $product->id
            ]);
    }

    public function test_it_is_paginated_data()
    {
        $this->json('GET', 'api/products')
            ->assertJsonStructure([
               'meta'
            ]);
    }
}
