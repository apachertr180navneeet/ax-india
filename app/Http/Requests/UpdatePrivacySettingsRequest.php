<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePrivacySettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'settings' => ['required', 'array'],
            'settings.*' => ['in:everyone,subscribers,only_me'],
        ];
    }

    public function messages(): array
    {
        return [
            'settings.required' => 'Privacy settings are required.',
            'settings.array' => 'Privacy settings must be an array.',
            'settings.*.in' => 'Each privacy setting must be one of: everyone, subscribers, only_me.',
        ];
    }
}
