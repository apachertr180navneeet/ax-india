<?php

namespace App\Models;

use App\Enums\VideoStatus;
use App\Enums\VideoVisibility;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'title', 'slug', 'description', 'thumbnail', 'duration',
        'file_path', 'file_size', 'mime_type', 'extension', 'resolution',
        'visibility', 'is_published', 'scheduled_at', 'allow_downloads',
        'views_count', 'likes_count', 'dislikes_count', 'comments_count',
        'category_id', 'status', 'rejected_reason',
        'is_short', 'is_live', 'stream_key', 'live_status', 'earnings',
    ];

    protected $casts = [
        'is_published' => 'bool',
        'allow_downloads' => 'bool',
        'is_short' => 'bool',
        'is_live' => 'bool',
        'scheduled_at' => 'datetime',
        'visibility' => VideoVisibility::class,
        'status' => VideoStatus::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'video_tags');
    }

    public function likes()
    {
        return $this->hasMany(VideoLike::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function files()
    {
        return $this->hasMany(VideoFile::class);
    }

    public function watchHistories()
    {
        return $this->hasMany(WatchHistory::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function reports()
    {
        return $this->hasMany(VideoReport::class);
    }

    public function downloads()
    {
        return $this->hasMany(Download::class);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopePending($query)
    {
        return $query->where('status', VideoStatus::Pending);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', VideoStatus::Approved);
    }

    public function scopeByVisibility($query, $visibility)
    {
        return $query->where('visibility', $visibility);
    }
}
