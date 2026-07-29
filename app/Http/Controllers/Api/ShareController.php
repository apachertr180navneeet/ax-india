<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class ShareController extends Controller
{
    use ApiResponse;

    public function show(int $videoId): JsonResponse
    {
        $video = Video::findOrFail($videoId);
        $url = url("/watch/{$video->slug}");
        $text = "Check out this video: {$video->title}";
        $encodedUrl = urlencode($url);
        $encodedText = urlencode($text);

        return $this->successResponse([
            'url' => $url,
            'whatsapp_url' => "https://wa.me/?text={$encodedText}%20{$encodedUrl}",
            'facebook_url' => "https://www.facebook.com/sharer/sharer.php?u={$encodedUrl}",
            'twitter_url' => "https://twitter.com/intent/tweet?text={$encodedText}&url={$encodedUrl}",
            'telegram_url' => "https://t.me/share/url?url={$encodedUrl}&text={$encodedText}",
            'email_subject' => $text,
            'embed_code' => "<iframe src=\"" . url("/embed/{$video->slug}") . "\" width=\"560\" height=\"315\" frameborder=\"0\" allowfullscreen></iframe>",
        ], 'Share links generated successfully');
    }
}
