<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportVideoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'reason' => ['required', 'in:spam,copyright,violence,hate_speech,adult_content,other'],
            'description' => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'reason.required' => 'Report reason is required.',
            'reason.in' => 'Reason must be one of: spam, copyright, violence, hate_speech, adult_content, other.',
            'description.max' => 'Description may not exceed 2000 characters.',
        ];
    }
}
