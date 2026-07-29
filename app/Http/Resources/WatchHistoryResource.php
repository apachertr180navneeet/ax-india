<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WatchHistoryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'video' => VideoListResource::make($this->whenLoaded('video')),
            'watched_at' => $this->watched_at?->toIso8601String(),
            'watch_duration' => $this->watch_duration,
            'completed' => $this->completed,
            'resume_at' => $this->resume_at,
            'human_date' => $this->watched_at?->diffForHumans(),
        ];
    }
}
