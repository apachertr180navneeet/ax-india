<?php

namespace App\Models;

use App\Enums\ReportReason;
use App\Enums\ReportStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'video_id', 'reason', 'description',
        'status', 'reviewed_by', 'reviewed_at',
    ];

    protected $casts = [
        'reason' => ReportReason::class,
        'status' => ReportStatus::class,
        'reviewed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
