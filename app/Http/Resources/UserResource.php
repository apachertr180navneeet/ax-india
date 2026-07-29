<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => trim($this->first_name . ' ' . $this->last_name),
            'email' => $this->email,
            'phone' => $this->phone,
            'avatar' => $this->avatar,
            'cover_image' => $this->cover_image,
            'avatar_url' => $this->avatar ? asset($this->avatar) : null,
            'cover_image_url' => $this->cover_image ? asset($this->cover_image) : null,
            'role' => $this->role,
            'status' => $this->status,
            'created_at' => $this->created_at?->toIso8601String(),
            'profile' => ProfileResource::make($this->whenLoaded('profile')),
        ];
    }
}
