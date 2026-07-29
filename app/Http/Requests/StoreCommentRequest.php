<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'body' => ['required', 'string', 'max:5000'],
            'parent_id' => ['nullable', 'exists:comments,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'body.required' => 'Comment body is required.',
            'body.max' => 'Comment may not exceed 5000 characters.',
            'parent_id.exists' => 'Parent comment does not exist.',
        ];
    }
}
