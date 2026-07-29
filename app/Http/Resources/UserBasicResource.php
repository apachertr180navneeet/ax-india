<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserBasicResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => trim($this->first_name . ' ' . $this->last_name),
            'username' => $this->when($this->relationLoaded('profile'), $this->profile?->username),
            'avatar_url' => $this->avatar ? asset($this->avatar) : null,
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
