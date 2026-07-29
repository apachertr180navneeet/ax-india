<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VideoLikeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'type' => ['required', 'in:like,dislike'],
        ];
    }

    public function messages(): array
    {
        return [
            'type.required' => 'Like type is required.',
            'type.in' => 'Type must be either like or dislike.',
        ];
    }
}
