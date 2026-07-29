<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShareResource extends JsonResource
{
    public function toArray($request): array
    {
        $url = $this->resource['url'] ?? '';
        $title = $this->resource['title'] ?? '';
        $description = $this->resource['description'] ?? '';
        $encodedUrl = rawurlencode($url);
        $encodedTitle = rawurlencode($title);
        $encodedDescription = rawurlencode($description);

        return [
            'share_url' => $url,
            'whatsapp_url' => "https://wa.me/?text={$encodedTitle}%20{$encodedUrl}",
            'facebook_url' => "https://www.facebook.com/sharer/sharer.php?u={$encodedUrl}",
            'twitter_url' => "https://twitter.com/intent/tweet?text={$encodedTitle}&url={$encodedUrl}",
            'telegram_url' => "https://t.me/share/url?url={$encodedUrl}&text={$encodedTitle}",
            'email_subject' => "Check this out: {$title}",
            'email_body' => "{$description}\n\n{$url}",
            'embed_code' => $this->embedCode($url),
        ];
    }

    private function embedCode(string $url): string
    {
        return '<iframe src="' . e($url) . '" frameborder="0" allowfullscreen></iframe>';
    }
}
