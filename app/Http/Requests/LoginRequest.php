<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required_without:phone', 'email'],
            'phone' => ['required_without:email', 'numeric'],
            'password' => ['required', 'string'],
            'remember' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required_without' => 'Email or phone number is required.',
            'phone.required_without' => 'Email or phone number is required.',
            'password.required' => 'Password is required.',
        ];
    }
}
