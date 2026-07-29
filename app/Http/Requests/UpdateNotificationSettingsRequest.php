<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNotificationSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'settings' => ['required', 'array'],
            'settings.*' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'settings.required' => 'Notification settings are required.',
            'settings.array' => 'Notification settings must be an array.',
            'settings.*.boolean' => 'Each notification setting must be true or false.',
        ];
    }
}
