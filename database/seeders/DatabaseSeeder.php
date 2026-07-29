<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            CategorySeeder::class,
            TagSeeder::class,
            UserSeeder::class,
            VideoSeeder::class,
            CommentSeeder::class,
        ]);
    }
}
