<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

class VideoLikeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'video_id' => Video::factory(),
            'type' => fake()->randomElement(['like', 'dislike']),
        ];
    }
}
