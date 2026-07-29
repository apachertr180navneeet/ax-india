<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProfileFactory extends Factory
{
    public function definition(): array
    {
        $username = fake()->unique()->userName() . rand(10, 9999);

        return [
            'user_id' => User::factory(),
            'username' => $username,
            'bio' => fake()->text(200),
            'gender' => fake()->randomElement(['male', 'female', 'other']),
            'dob' => fake()->dateTimeBetween('1970-01-01', '2006-12-31')->format('Y-m-d'),
            'avatar' => null,
            'cover_image' => null,
            'country' => fake()->country(),
            'state' => fake()->state(),
            'city' => fake()->city(),
            'website' => fake()->url(),
            'social_links' => null,
            'privacy_settings' => null,
            'notification_settings' => null,
        ];
    }
}
