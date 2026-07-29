<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVideoStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('moderate videos');
    }

    public function rules(): array
    {
        return [
            'status' => ['required', 'in:approved,rejected'],
            'rejected_reason' => ['required_if:status,rejected', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'Status is required.',
            'status.in' => 'Status must be either approved or rejected.',
            'rejected_reason.required_if' => 'Rejected reason is required when rejecting a video.',
            'rejected_reason.max' => 'Rejected reason may not exceed 500 characters.',
        ];
    }
}
