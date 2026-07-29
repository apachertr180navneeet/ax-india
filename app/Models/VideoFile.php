<?php

namespace App\Models;

use App\Enums\ProcessingStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'video_id', 'file_path', 'file_type', 'mime_type', 'size',
        'resolution', 'duration', 'is_processed', 'processing_status',
    ];

    protected $casts = [
        'is_processed' => 'bool',
        'processing_status' => ProcessingStatus::class,
    ];

    public function video()
    {
        return $this->belongsTo(Video::class);
    }
}
