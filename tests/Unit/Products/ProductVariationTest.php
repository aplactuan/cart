<?php

namespace Tests\Unit\Products;

use App\Cart\Money;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\ProductVariationType;
use App\Models\Stock;
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

    public function test_it_return_a_money_instance_for_the_price_variation()
    {
        $variation = ProductVariation::factory()->create();

        $this->assertInstanceOf(Money::class, $variation->price);
    }

    public function test_it_returns_a_formatted_price()
    {
        $variation = ProductVariation::factory()->create([
            'price' => 1000
        ]);

        $this->assertEquals($variation->formatted_price, '£10.00');
    }

    public function test_it_returns_the_base_product_price_if_variation_price_is_null()
    {
        $product = Product::factory()->create([
            'price' => 1000
        ]);

        $variation = ProductVariation::factory()->create([
            'price' => null,
            'product_id' => $product->id
        ]);

        $this->assertEquals($variation->formatted_price, $product->formatted_price);
    }

    public function test_it_can_check_if_the_variation_price_is_different_to_the_product()
    {
        $product = Product::factory()->create([
            'price' => 1000
        ]);

        $variation = ProductVariation::factory()->create([
            'price' => 2000,
            'product_id' => $product->id
        ]);

        $this->assertTrue($variation->priceVaries());
    }

    public function test_it_has_many_stocks()
    {
        $variation = ProductVariation::factory()->hasStocks()->create();

        $this->assertInstanceOf(Stock::class, $variation->stocks->first());
    }

    public function test_it_has_stock_information()
    {
        $variation = ProductVariation::factory()->hasStocks()->create();

        $this->assertInstanceOf(ProductVariation::class, $variation->stock->first());
    }

    public function test_it_has_stock_count_pivot_within_stock_information()
    {
        $variation = ProductVariation::factory()->create();

        $variation->stocks()->save(
            Stock::factory()->create([
                'quantity' => $quantity = 5
            ])
        );

        $this->assertEquals($variation->stock->first()->pivot->stock, $quantity);
    }

    public function test_it_has_in_stock_pivot_within_stock_information()
    {
        $variation = ProductVariation::factory()->create();

        $variation->stocks()->save(
            Stock::factory()->create([
                'quantity' => $quantity = 5
            ])
        );

        $this->assertTrue($variation->stock->first()->pivot->in_stock);
    }
}
