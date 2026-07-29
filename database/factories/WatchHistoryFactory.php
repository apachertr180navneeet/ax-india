<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

class WatchHistoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'video_id' => Video::factory(),
            'watched_at' => now(),
            'watch_duration' => fake()->randomFloat(2, 0, 600),
            'completed' => fake()->boolean(),
            'resume_at' => fake()->randomFloat(2, 0, 600),
        ];
    }
}
