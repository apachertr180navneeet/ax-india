<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    private static array $names = [
        'Music', 'Gaming', 'Education', 'Entertainment', 'Sports',
        'News', 'Technology', 'Comedy', 'Vlogs', 'DIY',
    ];

    private static int $index = 0;

    public function definition(): array
    {
        $name = self::$names[self::$index % count(self::$names)];
        self::$index++;

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->sentence(),
            'is_active' => true,
        ];
    }
}
