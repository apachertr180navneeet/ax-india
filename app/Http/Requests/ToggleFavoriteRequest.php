<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ToggleFavoriteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'video_id' => ['required', 'exists:videos,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'video_id.required' => 'Video ID is required.',
            'video_id.exists' => 'Selected video does not exist.',
        ];
    }
}
