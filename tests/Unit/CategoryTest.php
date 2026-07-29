<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_has_children()
    {
        $parent = Category::factory()->create();
        $child = Category::factory()->create(['parent_id' => $parent->id]);

        $this->assertTrue($parent->children->contains($child));
    }

    public function test_category_belongs_to_parent()
    {
        $parent = Category::factory()->create();
        $child = Category::factory()->create(['parent_id' => $parent->id]);

        $this->assertInstanceOf(Category::class, $child->parent);
        $this->assertEquals($parent->id, $child->parent->id);
    }

    public function test_category_has_many_videos()
    {
        $category = Category::factory()->create();
        $video = Video::factory()->create(['category_id' => $category->id]);

        $this->assertTrue($category->videos->contains($video));
    }

    public function test_category_is_active_scope()
    {
        Category::factory()->create(['is_active' => true]);
        Category::factory()->create(['is_active' => false]);

        $activeCount = Category::where('is_active', true)->count();
        $this->assertEquals(1, $activeCount);
    }
}
