<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    public function toArray($request): array
    {
        $user = $request->user();

        return [
            'id' => $this->id,
            'body' => $this->body,
            'is_pinned' => $this->is_pinned,
            'is_edited' => $this->is_edited,
            'likes_count' => $this->likes_count,
            'is_liked' => $this->when($user, fn() => $this->relationLoaded('likes')
                ? $this->likes->contains('user_id', $user?->id)
                : null),
            'replies_count' => $this->whenCounted('replies'),
            'user' => UserBasicResource::make($this->whenLoaded('user')),
            'replies' => CommentResource::collection($this->whenLoaded('replies')),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
            'relative_date' => $this->created_at?->diffForHumans(),
        ];
    }
}
