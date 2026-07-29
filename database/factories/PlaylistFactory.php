<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PlaylistFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->words(3, true);

        return [
            'user_id' => User::factory(),
            'name' => $name,
            'slug' => Str::slug($name) . '-' . uniqid(),
            'description' => fake()->sentence(),
            'visibility' => 'public',
        ];
    }
}
