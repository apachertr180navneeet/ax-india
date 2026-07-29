<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait FileUploadTrait
{
    public function uploadFile(UploadedFile $file, string $path, string $disk = 'public'): string
    {
        return $file->store($path, $disk);
    }

    public function deleteFile(string $path, string $disk = 'public'): bool
    {
        if (Storage::disk($disk)->exists($path)) {
            return Storage::disk($disk)->delete($path);
        }

        return false;
    }

    public function getFileUrl(string $path, string $disk = 'public'): string
    {
        return Storage::disk($disk)->url($path);
    }
}
