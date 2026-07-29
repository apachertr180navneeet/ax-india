<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $videos = Video::all();

        $commentCount = rand(30, 50);
        $comments = [];

        for ($i = 0; $i < $commentCount; $i++) {
            $comments[] = Comment::create([
                'user_id' => $users->random()->id,
                'video_id' => $videos->random()->id,
                'body' => fake()->text(200),
                'is_pinned' => false,
                'is_edited' => false,
                'likes_count' => fake()->numberBetween(0, 100),
                'status' => 'active',
            ]);
        }

        // Add replies to some comments
        $parentComments = collect($comments)->random(min(10, count($comments)));
        foreach ($parentComments as $parent) {
            $replyCount = rand(1, 3);
            for ($j = 0; $j < $replyCount; $j++) {
                Comment::create([
                    'user_id' => $users->random()->id,
                    'video_id' => $parent->video_id,
                    'parent_id' => $parent->id,
                    'body' => fake()->text(200),
                    'is_pinned' => false,
                    'is_edited' => false,
                    'likes_count' => fake()->numberBetween(0, 50),
                    'status' => 'active',
                ]);
            }
        }
    }
}
