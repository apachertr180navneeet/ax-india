<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'data' => $this->data,
            'read_at' => $this->read_at?->toIso8601String(),
            'is_read' => !is_null($this->read_at),
            'time_ago' => $this->created_at?->diffForHumans(),
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
