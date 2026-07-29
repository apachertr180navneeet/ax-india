<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VideoListResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'thumbnail_url' => $this->thumbnail ? asset($this->thumbnail) : null,
            'duration' => $this->duration,
            'formatted_duration' => $this->duration ? gmdate('H:i:s', $this->duration) : null,
            'views_count' => $this->views_count,
            'formatted_views' => $this->abbreviateNumber($this->views_count ?? 0),
            'likes_count' => $this->likes_count,
            'comments_count' => $this->comments_count,
            'category_name' => $this->whenLoaded('category', fn() => $this->category?->name),
            'user' => UserBasicResource::make($this->whenLoaded('user')),
            'created_at' => $this->created_at?->toIso8601String(),
            'relative_date' => $this->created_at?->diffForHumans(),
        ];
    }

    private function abbreviateNumber(int $number): string
    {
        if ($number >= 1_000_000_000) {
            return round($number / 1_000_000_000, 1) . 'B';
        }
        if ($number >= 1_000_000) {
            return round($number / 1_000_000, 1) . 'M';
        }
        if ($number >= 1_000) {
            return round($number / 1_000, 1) . 'K';
        }
        return (string) $number;
    }
}
