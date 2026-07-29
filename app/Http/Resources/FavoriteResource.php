<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FavoriteResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'video' => VideoListResource::make($this->whenLoaded('video')),
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
