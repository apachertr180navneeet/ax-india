<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'creator' => UserBasicResource::make($this->whenLoaded('creator')),
            'subscriber_count' => $this->when($this->relationLoaded('creator'), fn() =>
                $this->creator?->subscribers()?->count()
            ),
            'notification_enabled' => $this->notification_enabled,
            'subscribed_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
