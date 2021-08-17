<?php

namespace Tests\Unit\Models\Categories;

use App\Models\Category;
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{
   public function test_it_many_children()
    {
        $category = Category::factory()->make();

        $category->children()->save(
            Category::factory()->make()
        );

        $this->assertInstanceOf(Category::class, $category->children()->first);
    }
}
