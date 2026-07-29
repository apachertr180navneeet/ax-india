<?php

namespace App\Models;

use App\Enums\LikeType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoLike extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'video_id', 'type',
    ];

    protected $casts = [
        'type' => LikeType::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function video()
    {
        return $this->belongsTo(Video::class);
    }
}
