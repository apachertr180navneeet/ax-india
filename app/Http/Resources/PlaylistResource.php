<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlaylistResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'thumbnail_url' => $this->thumbnail ? asset($this->thumbnail) : null,
            'visibility' => $this->visibility,
            'videos_count' => $this->whenCounted('videos'),
            'sort_order' => $this->sort_order,
            'user' => UserBasicResource::make($this->whenLoaded('user')),
            'videos' => VideoListResource::collection($this->whenLoaded('videos')),
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
