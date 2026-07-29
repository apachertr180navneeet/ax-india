<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\Gender;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'min:3', 'max:30',
                Rule::unique('profiles', 'username')->ignore(auth()->user()->profile?->id),
            ],
            'bio' => ['nullable', 'string', 'max:500'],
            'gender' => ['nullable', new Enum(Gender::class)],
            'dob' => ['nullable', 'date', 'before:' . now()->subYears(18)->toDateString()],
            'website' => ['nullable', 'url'],
            'country' => ['nullable', 'string'],
            'state' => ['nullable', 'string'],
            'city' => ['nullable', 'string'],
            'social_links' => ['nullable', 'array'],
        ];
    }

    public function messages(): array
    {
        return [
            'username.required' => 'Username is required.',
            'username.unique' => 'This username is already taken.',
            'username.min' => 'Username must be at least 3 characters.',
            'username.max' => 'Username may not exceed 30 characters.',
            'bio.max' => 'Bio may not exceed 500 characters.',
            'dob.before' => 'You must be at least 18 years old.',
            'website.url' => 'Please provide a valid URL.',
        ];
    }
}
