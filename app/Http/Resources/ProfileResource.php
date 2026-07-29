<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'bio' => $this->bio,
            'gender' => $this->gender,
            'dob' => $this->dob?->toIso8601String(),
            'avatar_url' => $this->avatar ? asset($this->avatar) : null,
            'cover_image_url' => $this->cover_image ? asset($this->cover_image) : null,
            'website' => $this->website,
            'country' => $this->country,
            'state' => $this->state,
            'city' => $this->city,
            'social_links' => $this->social_links,
            'privacy_settings' => $this->privacy_settings,
            'notification_settings' => $this->notification_settings,
        ];
    }
}
