<?php

namespace Tests\Unit\Products;

use App\Cart\Money;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\Stock;
use Database\Factories\StockFactory;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function test_it_uses_the_slug_for_route_key_name()
    {
        $product = new Product();

        $this->assertEquals($product->getRouteKeyName(), 'slug');
    }

    public function test_it_has_many_categories()
    {
        $product = Product::factory()->hasCategories(1)->create();

        $this->assertInstanceOf(Category::class, $product->categories->first());
    }

    public function test_it_has_many_variations()
    {
        $product = Product::factory()->hasVariations(2)->create();

        $this->assertInstanceOf(ProductVariation::class, $product->variations->first());
    }

    public function test_it_return_a_money_instance_for_the_price()
    {
        $product = Product::factory()->create();

        $this->assertInstanceOf(Money::class, $product->price);
    }

    public function test_it_returns_a_formatted_price()
    {
        $product = Product::factory()->create([
            'price' => 1000
        ]);

        $this->assertEquals($product->formatted_price, '£10.00');
    }

    public function test_it_can_check_if_its_in_stock()
    {
        $product = Product::factory()->create();

        $product->variations()->save(
            ProductVariation::factory()->hasStocks()->create()
        );

        $this->assertTrue($product->inStock());
    }

    public function test_it_can_get_stock_count()
    {
        $product = Product::factory()->create();

        $product->variations()->save(
            $variation = ProductVariation::factory()->create()
        );

        Stock::factory()->create([
            'quantity' => $quantity = 5,
            'product_variation_id' => $variation->id
        ]);

        $this->assertEquals($product->stockCount(), $quantity);
    }
}
