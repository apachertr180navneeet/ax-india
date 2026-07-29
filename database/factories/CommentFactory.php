<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'video_id' => Video::factory(),
            'body' => fake()->text(200),
            'is_pinned' => false,
            'is_edited' => false,
            'likes_count' => 0,
            'status' => 'active',
        ];
    }
}
