<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VideoResource extends JsonResource
{
    public function toArray($request): array
    {
        $user = $request->user();

        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'thumbnail_url' => $this->thumbnail ? asset($this->thumbnail) : null,
            'duration' => $this->duration,
            'formatted_duration' => $this->duration ? gmdate('H:i:s', $this->duration) : null,
            'file_url' => $this->file_path ? asset($this->file_path) : null,
            'file_size' => $this->file_size,
            'mime_type' => $this->mime_type,
            'extension' => $this->extension,
            'resolution' => $this->resolution,
            'visibility' => $this->visibility,
            'is_published' => $this->is_published,
            'scheduled_at' => $this->scheduled_at?->toIso8601String(),
            'allow_downloads' => $this->allow_downloads,
            'views_count' => $this->views_count,
            'formatted_views' => $this->abbreviateNumber($this->views_count ?? 0),
            'likes_count' => $this->likes_count,
            'dislikes_count' => $this->dislikes_count,
            'comments_count' => $this->comments_count,
            'relative_date' => $this->created_at?->diffForHumans(),
            'is_liked' => $this->when($user, fn() => $this->relationLoaded('likes')
                ? $this->likes->contains('user_id', $user?->id)
                : null),
            'is_favorited' => $this->when($user, fn() => $this->relationLoaded('favorites')
                ? $this->favorites->contains('user_id', $user?->id)
                : null),
            'category' => CategoryResource::make($this->whenLoaded('category')),
            'user' => UserBasicResource::make($this->whenLoaded('user')),
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
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
