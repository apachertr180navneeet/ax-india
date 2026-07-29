<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_search_videos()
    {
        Video::factory()->create([
            'title' => 'Laravel Tutorial for Beginners',
            'is_published' => true,
        ]);
        Video::factory()->create([
            'title' => 'PHP Advanced Concepts',
            'is_published' => true,
        ]);

        $response = $this->getJson('/api/v1/search?q=Laravel');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data',
            ]);
    }

    public function test_search_returns_results()
    {
        Video::factory()->create([
            'title' => 'Unique Search Test Video',
            'is_published' => true,
        ]);

        $response = $this->getJson('/api/v1/search?q=Unique+Search');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Search results retrieved successfully',
            ]);
    }
}
