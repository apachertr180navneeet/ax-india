<?php

namespace App\Models;

use App\Enums\VideoVisibility;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'slug', 'description', 'thumbnail',
        'visibility', 'sort_order',
    ];

    protected $casts = [
        'visibility' => VideoVisibility::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function videos()
    {
        return $this->belongsToMany(Video::class, 'playlist_videos')
            ->withPivot('sort_order')
            ->orderBy('pivot_sort_order');
    }
}
