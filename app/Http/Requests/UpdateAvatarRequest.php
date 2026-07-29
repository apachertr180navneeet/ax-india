<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAvatarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'avatar' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'avatar.required' => 'Avatar image is required.',
            'avatar.image' => 'Avatar must be an image file.',
            'avatar.mimes' => 'Avatar must be a file of type: jpeg, png, jpg, gif, webp.',
            'avatar.max' => 'Avatar may not be larger than 5MB.',
        ];
    }
}
