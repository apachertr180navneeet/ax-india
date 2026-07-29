<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WatchHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'video_id', 'watched_at', 'watch_duration',
        'completed', 'resume_at',
    ];

    protected $casts = [
        'watched_at' => 'datetime',
        'completed' => 'bool',
        'resume_at' => 'decimal:8,2',
        'watch_duration' => 'decimal:10,2',
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
