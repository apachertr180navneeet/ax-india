<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'target_url',
        'image_path',
        'video_path',
        'impressions',
        'clicks',
        'is_active',
    ];
}
