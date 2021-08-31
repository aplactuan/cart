<?php

namespace Tests\Unit\Products;

use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\ProductVariationType;
use Tests\TestCase;

class ProductVariationTest extends TestCase
{
    public function test_it_has_one_variation_type()
    {
        $product = Product::factory()->hasVariations()->create();

        $this->assertInstanceOf(ProductVariationType::class,$product->variations->first()->type);
    }

    public function test_it_belongs_to_a_product()
    {
        $variation = ProductVariation::factory()->create();

        $this->assertInstanceOf(Product::class, $variation->product);
    }
}
