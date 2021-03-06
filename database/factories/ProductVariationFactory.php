<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\ProductVariationType;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductVariationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductVariation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $variation_type = ProductVariationType::factory()->create();
        return [
            'product_id' => Product::factory()->create()->id,
            'name' => $this->faker->unique->name(),
            'product_variation_type_id' => $variation_type->id
        ];
    }
}
