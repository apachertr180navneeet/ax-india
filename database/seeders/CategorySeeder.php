<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Music', 'Gaming', 'Education', 'Entertainment', 'Sports',
            'News', 'Technology', 'Comedy', 'Vlogs', 'DIY',
        ];

        foreach ($categories as $name) {
            Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => fake()->sentence(),
                'is_active' => true,
            ]);
        }
    }
}
