<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ToggleSubscriptionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'creator_id' => ['required', 'exists:users,id', Rule::notIn([auth()->id()])],
        ];
    }

    public function messages(): array
    {
        return [
            'creator_id.required' => 'Creator ID is required.',
            'creator_id.exists' => 'Selected creator does not exist.',
            'creator_id.not_in' => 'You cannot subscribe to yourself.',
        ];
    }
}
