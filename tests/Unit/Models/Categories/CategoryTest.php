<?php

namespace Tests\Unit\Models\Categories;

use App\Models\Category;
use Tests\TestCase;

class CategoryTest extends TestCase
{
   public function test_it_many_children()
    {
        /*$category = Category::factory()->create();

        $category->children()->save(
            Category::factory()->create()
        );*/

        $category = Category::factory()->hasChildren(1)->create();

        $this->assertInstanceOf(Category::class, $category->children()->first());
    }

    public function test_it_can_only_fetch_parent()
    {
        $category = Category::factory()->hasChildren(1)->create();

        $this->assertEquals(1, Category::parents()->count());
    }

    public function test_it_is_orderable_by_ordered_number()
    {
        $category = Category::factory()->create([
            'order' => 2
        ]);

        $anotherCategory = Category::factory()->create([
           'order' => 1
        ]);

        $this->assertEquals($anotherCategory->name, Category::ordered()->first()->name);
    }
}
