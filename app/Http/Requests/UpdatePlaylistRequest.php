<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePlaylistRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && $this->route('playlist') && $this->user()->can('update', $this->route('playlist'));
    }

    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'visibility' => ['sometimes', 'in:public,unlisted,private'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.max' => 'Playlist name may not exceed 255 characters.',
            'description.max' => 'Description may not exceed 2000 characters.',
            'visibility.in' => 'Visibility must be one of: public, unlisted, private.',
        ];
    }
}
