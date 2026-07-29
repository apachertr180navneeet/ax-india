<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'q' => ['required', 'string', 'max:255'],
            'type' => ['nullable', 'in:video,creator,category,tag'],
            'sort' => ['nullable', 'in:relevance,date,views,rating'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:50'],
        ];
    }

    public function messages(): array
    {
        return [
            'q.required' => 'Search query is required.',
            'q.max' => 'Search query may not exceed 255 characters.',
            'type.in' => 'Search type must be one of: video, creator, category, tag.',
            'sort.in' => 'Sort must be one of: relevance, date, views, rating.',
            'per_page.min' => 'Results per page must be at least 1.',
            'per_page.max' => 'Results per page may not exceed 50.',
        ];
    }
}
