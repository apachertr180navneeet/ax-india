<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'username', 'bio', 'gender', 'dob', 'avatar', 'cover_image',
        'website', 'country', 'state', 'city', 'social_links',
        'privacy_settings', 'notification_settings',
    ];

    protected $casts = [
        'social_links' => 'array',
        'privacy_settings' => 'array',
        'notification_settings' => 'array',
        'dob' => 'date',
    ];

    protected static function booted()
    {
        static::creating(function ($profile) {
            if (!$profile->user_id) {
                $profile->user_id = auth()->id();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
