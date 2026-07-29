<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TagFactory extends Factory
{
    private static array $names = [
        'trending', 'viral', 'funny', 'tutorial', 'music',
        'gameplay', 'review', 'unboxing', 'live', 'shorts',
    ];

    private static int $index = 0;

    public function definition(): array
    {
        $name = self::$names[self::$index % count(self::$names)];
        self::$index++;

        return [
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }
}
