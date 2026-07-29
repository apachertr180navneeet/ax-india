<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCoverRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'cover_image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:10240'],
        ];
    }

    public function messages(): array
    {
        return [
            'cover_image.required' => 'Cover image is required.',
            'cover_image.image' => 'Cover must be an image file.',
            'cover_image.mimes' => 'Cover must be a file of type: jpeg, png, jpg, gif, webp.',
            'cover_image.max' => 'Cover may not be larger than 10MB.',
        ];
    }
}
