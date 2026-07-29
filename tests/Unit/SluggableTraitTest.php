<?php

namespace Tests\Unit;

use App\Models\Video;
use App\Traits\Sluggable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SluggableTraitTest extends TestCase
{
    use RefreshDatabase;

    private $sluggable;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sluggable = new class
        {
            use Sluggable;

            public function callGenerate($model, $title, $field = 'slug')
            {
                return $this->generateSlug($model, $title, $field);
            }
        };
    }

    public function test_generate_slug_creates_unique_slug()
    {
        $slug = $this->sluggable->callGenerate(new Video(), 'My Awesome Video');

        $this->assertEquals('my-awesome-video', $slug);
    }

    public function test_generate_slug_handles_duplicates()
    {
        Video::factory()->create(['slug' => 'my-awesome-video']);

        $slug = $this->sluggable->callGenerate(new Video(), 'My Awesome Video');

        $this->assertEquals('my-awesome-video-1', $slug);
    }
}
