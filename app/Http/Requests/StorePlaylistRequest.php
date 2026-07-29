<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePlaylistRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'visibility' => ['required', 'in:public,unlisted,private'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Playlist name is required.',
            'name.max' => 'Playlist name may not exceed 255 characters.',
            'description.max' => 'Description may not exceed 2000 characters.',
            'visibility.required' => 'Visibility setting is required.',
            'visibility.in' => 'Visibility must be one of: public, unlisted, private.',
        ];
    }
}
