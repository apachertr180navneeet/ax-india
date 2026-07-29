<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VerifyEmailRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => ['required', 'integer'],
            'hash' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'User ID is required.',
            'hash.required' => 'Verification hash is required.',
        ];
    }
}
