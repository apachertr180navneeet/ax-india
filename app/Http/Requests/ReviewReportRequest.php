<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('review reports');
    }

    public function rules(): array
    {
        return [
            'status' => ['required', 'in:reviewed,dismissed,action_taken'],
            'admin_note' => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'Report status is required.',
            'status.in' => 'Status must be one of: reviewed, dismissed, action_taken.',
            'admin_note.max' => 'Admin note may not exceed 2000 characters.',
        ];
    }
}
