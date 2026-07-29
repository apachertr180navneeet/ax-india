<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpamDetectionLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'target_type',
        'target_id',
        'user_id',
        'spam_score',
        'detected_flags',
        'action_taken',
    ];

    protected $casts = [
        'detected_flags' => 'array',
        'spam_score' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
