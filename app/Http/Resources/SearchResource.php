<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SearchResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'query' => $this->resource['query'] ?? null,
            'total_results' => $this->resource['total_results'] ?? 0,
            'videos' => VideoListResource::collection($this->resource['videos'] ?? []),
            'users' => UserBasicResource::collection($this->resource['users'] ?? []),
            'categories' => CategoryResource::collection($this->resource['categories'] ?? []),
            'tags' => TagResource::collection($this->resource['tags'] ?? []),
        ];
    }
}
