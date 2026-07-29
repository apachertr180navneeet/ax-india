<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class VideoFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->unique()->sentence(6);

        return [
            'user_id' => User::factory(),
            'title' => $title,
            'slug' => Str::slug($title) . '-' . uniqid(),
            'description' => fake()->paragraph(),
            'thumbnail' => 'thumbnails/' . fake()->uuid() . '.jpg',
            'duration' => fake()->randomFloat(2, 0.5, 600),
            'file_path' => 'videos/' . fake()->uuid() . '.mp4',
            'file_size' => fake()->numberBetween(1000000, 500000000),
            'mime_type' => 'video/mp4',
            'extension' => 'mp4',
            'resolution' => fake()->randomElement(['720p', '1080p', '4K']),
            'visibility' => 'public',
            'is_published' => true,
            'allow_downloads' => true,
            'views_count' => fake()->numberBetween(0, 100000),
            'likes_count' => fake()->numberBetween(0, 5000),
            'dislikes_count' => fake()->numberBetween(0, 500),
            'comments_count' => fake()->numberBetween(0, 500),
            'category_id' => Category::factory(),
            'status' => 'approved',
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function ($video) {
            $tags = Tag::inRandomOrder()->take(rand(2, 4))->get();
            $video->tags()->attach($tags);
        });
    }
}
