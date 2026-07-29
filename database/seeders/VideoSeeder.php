<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use App\Models\Video;
use App\Models\VideoLike;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class VideoSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $categories = Category::all();
        $tags = Tag::all();

        // 10 videos for admin (user id 1)
        for ($i = 1; $i <= 10; $i++) {
            $title = fake()->unique()->sentence(6);
            $video = Video::create([
                'user_id' => 1,
                'title' => $title,
                'slug' => Str::slug($title) . '-' . uniqid(),
                'description' => fake()->paragraphs(3, true),
                'thumbnail' => 'thumbnails/admin-video-' . $i . '.jpg',
                'duration' => fake()->randomFloat(2, 30, 600),
                'file_path' => 'videos/admin-video-' . $i . '.mp4',
                'file_size' => fake()->numberBetween(5000000, 200000000),
                'mime_type' => 'video/mp4',
                'extension' => 'mp4',
                'resolution' => fake()->randomElement(['720p', '1080p', '4K']),
                'visibility' => 'public',
                'is_published' => true,
                'allow_downloads' => true,
                'views_count' => fake()->numberBetween(100, 50000),
                'likes_count' => fake()->numberBetween(10, 2000),
                'dislikes_count' => fake()->numberBetween(0, 200),
                'comments_count' => fake()->numberBetween(0, 200),
                'category_id' => $categories->random()->id,
                'status' => 'approved',
            ]);

            $video->tags()->attach($tags->random(rand(2, 4))->pluck('id'));
        }

        // 10 videos distributed among other users (ids 2+)
        $otherUsers = $users->where('id', '>', 1);
        for ($i = 1; $i <= 10; $i++) {
            $user = $otherUsers->random();
            $title = fake()->unique()->sentence(6);
            $video = Video::create([
                'user_id' => $user->id,
                'title' => $title,
                'slug' => Str::slug($title) . '-' . uniqid(),
                'description' => fake()->paragraphs(3, true),
                'thumbnail' => 'thumbnails/user-video-' . $i . '.jpg',
                'duration' => fake()->randomFloat(2, 30, 600),
                'file_path' => 'videos/user-video-' . $i . '.mp4',
                'file_size' => fake()->numberBetween(5000000, 200000000),
                'mime_type' => 'video/mp4',
                'extension' => 'mp4',
                'resolution' => fake()->randomElement(['720p', '1080p', '4K']),
                'visibility' => 'public',
                'is_published' => true,
                'allow_downloads' => true,
                'views_count' => fake()->numberBetween(100, 50000),
                'likes_count' => fake()->numberBetween(10, 2000),
                'dislikes_count' => fake()->numberBetween(0, 200),
                'comments_count' => fake()->numberBetween(0, 200),
                'category_id' => $categories->random()->id,
                'status' => 'approved',
            ]);

            $video->tags()->attach($tags->random(rand(2, 4))->pluck('id'));
        }

        // Add likes/dislikes for each video from other users
        $videos = Video::all();
        foreach ($videos as $video) {
            $otherUsersForLikes = $users->where('id', '!=', $video->user_id);
            $likeCount = rand(0, 5);
            $dislikeCount = rand(0, 2);

            $likers = $otherUsersForLikes->random(min($likeCount, $otherUsersForLikes->count()));
            foreach ($likers as $liker) {
                VideoLike::firstOrCreate([
                    'user_id' => $liker->id,
                    'video_id' => $video->id,
                ], [
                    'type' => 'like',
                ]);
            }

            if ($likeCount > 0) {
                $remaining = $otherUsersForLikes->whereNotIn('id', $likers->pluck('id'));
                $dislikers = $remaining->random(min($dislikeCount, $remaining->count()));
                foreach ($dislikers as $disliker) {
                    VideoLike::firstOrCreate([
                        'user_id' => $disliker->id,
                        'video_id' => $video->id,
                    ], [
                        'type' => 'dislike',
                    ]);
                }
            }
        }
    }
}
