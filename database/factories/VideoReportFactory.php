<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

class VideoReportFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'video_id' => Video::factory(),
            'reason' => fake()->randomElement(['spam', 'copyright', 'violence', 'harassment', 'other']),
            'description' => fake()->paragraph(),
            'status' => 'pending',
        ];
    }
}
