<?php

namespace Database\Factories;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        $firstName = fake()->firstName();
        $lastName = fake()->lastName();

        return [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'full_name' => $firstName . ' ' . $lastName,
            'slug' => Str::slug($firstName . ' ' . $lastName . '-' . uniqid()),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->unique()->numerify('##########'),
            'password' => static::$password ??= Hash::make('password'),
            'email_verified_at' => now(),
            'role' => 'user',
            'status' => 'active',
            'address' => fake()->address(),
            'area' => fake()->streetAddress(),
            'city' => fake()->city(),
            'state' => fake()->state(),
            'country' => fake()->country(),
            'country_code' => 1,
            'zipcode' => fake()->postcode(),
            'latitude' => fake()->latitude(),
            'longitude' => fake()->longitude(),
            'timezone' => fake()->timezone(),
            'avatar' => '',
            'bio' => '',
            'device_token' => '',
            'device_type' => 'ios',
            'remember_token' => Str::random(10),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
        ]);
    }

    public function configure(): static
    {
        return $this->afterCreating(function ($user) {
            Profile::factory()->create(['user_id' => $user->id]);
        });
    }
}
