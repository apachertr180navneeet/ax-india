<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadVideoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'video' => ['required', 'file', 'mimes:mp4,mov,avi,mkv,webm', 'max:512000'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['string', 'max:50'],
            'visibility' => ['required', 'in:public,unlisted,private,scheduled'],
            'scheduled_at' => ['nullable', 'date', 'after:now', 'required_if:visibility,scheduled'],
            'allow_downloads' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Video title is required.',
            'title.max' => 'Title may not exceed 255 characters.',
            'video.required' => 'Video file is required.',
            'video.file' => 'Please upload a valid video file.',
            'video.mimes' => 'Video must be a file of type: mp4, mov, avi, mkv, webm.',
            'video.max' => 'Video may not be larger than 500MB.',
            'thumbnail.image' => 'Thumbnail must be an image file.',
            'thumbnail.mimes' => 'Thumbnail must be a file of type: jpeg, png, jpg, webp.',
            'thumbnail.max' => 'Thumbnail may not be larger than 5MB.',
            'category_id.exists' => 'Selected category does not exist.',
            'tags.*.max' => 'Each tag may not exceed 50 characters.',
            'visibility.required' => 'Visibility setting is required.',
            'visibility.in' => 'Visibility must be one of: public, unlisted, private, scheduled.',
            'scheduled_at.required_if' => 'Scheduled date is required when visibility is scheduled.',
            'scheduled_at.after' => 'Scheduled date must be in the future.',
        ];
    }
}
