<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DemoWatchController extends Controller
{
    /**
     * Static demo catalogue for UI-only watch player (no DB / upload required).
     */
    public static function catalogue(): array
    {
        $sampleVideos = [
            'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4',
            'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerEscapes.mp4',
            'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerJoyrides.mp4',
            'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerMeltdowns.mp4',
        ];

        return [
            1 => [
                'id' => 1,
                'title' => 'Sanctuary of Light: Architectural Calm & Linen Spaces',
                'channel' => 'AX Studio',
                'series' => 'Heritage Series',
                'avatar' => 'AX',
                'subscribers' => '128K',
                'views' => '48K',
                'ago' => '2 days ago',
                'duration' => '14:28',
                'likes' => '3.2K',
                'thumb' => 'assets/web/img/thumb1.png',
                'video_url' => $sampleVideos[0],
                'description' => "Walk through serene interiors where soft linen, natural light, and calm architecture meet.\n\nIn this episode of Heritage Series we explore tranquil living rooms, textured fabrics, and the quiet luxury of daylight design.",
            ],
            2 => [
                'id' => 2,
                'title' => 'Whispers of the Summit: Golden Hour Cinematic Journey',
                'channel' => 'Highland Stories',
                'series' => null,
                'avatar' => 'HS',
                'subscribers' => '256K',
                'views' => '125K',
                'ago' => '5 days ago',
                'duration' => '22:05',
                'likes' => '9.8K',
                'thumb' => 'assets/web/img/hero.png',
                'video_url' => $sampleVideos[1],
                'description' => "A cinematic climb through golden-hour ridges and mountain silence.\n\nShot on location with ambient soundscapes — perfect for focus, travel inspiration, or weekend unwinding.",
            ],
            3 => [
                'id' => 3,
                'title' => 'The Art of Parchment Calligraphy & Bone Inlays',
                'channel' => 'Paper & Ink Masters',
                'series' => null,
                'avatar' => 'PM',
                'subscribers' => '64K',
                'views' => '19K',
                'ago' => '1 week ago',
                'duration' => '08:42',
                'likes' => '1.1K',
                'thumb' => 'assets/web/img/thumb1.png',
                'video_url' => $sampleVideos[2],
                'description' => "Learn classic parchment calligraphy techniques and delicate bone inlay craftsmanship in this hands-on studio session.",
            ],
            4 => [
                'id' => 4,
                'title' => 'Almond Silk Harmonies: Acoustic Ambient Live Performance',
                'channel' => 'Almond Sessions',
                'series' => null,
                'avatar' => 'AS',
                'subscribers' => '412K',
                'views' => '310K',
                'ago' => '2 weeks ago',
                'duration' => '45:10',
                'likes' => '22K',
                'thumb' => 'assets/web/img/hero.png',
                'video_url' => $sampleVideos[3],
                'description' => "Live acoustic ambient performance with silk-toned strings and warm room reverb — an evening session from Almond Sessions.",
            ],
        ];
    }

    public function show(int $id): View|RedirectResponse
    {
        $catalogue = self::catalogue();

        if (! isset($catalogue[$id])) {
            return redirect()->route('play.demo', ['id' => 1]);
        }

        $video = $catalogue[$id];
        $related = collect($catalogue)->except($id)->values();

        $comments = [
            ['avatar' => 'RK', 'name' => 'Riya Kapoor', 'ago' => '1 day ago', 'body' => 'The lighting in this is unreal — perfect for weekend mood.'],
            ['avatar' => 'AM', 'name' => 'Arjun Mehta', 'ago' => '2 days ago', 'body' => 'Subscribed instantly. More heritage series please!'],
            ['avatar' => 'NS', 'name' => 'Neha Sharma', 'ago' => '3 days ago', 'body' => 'UI looks so clean. Loving the watch experience.'],
        ];

        return view('web.videos.watch-demo', compact('video', 'related', 'comments'));
    }
}
