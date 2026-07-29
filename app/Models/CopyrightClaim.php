<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CopyrightClaim extends Model
{
    use HasFactory;

    protected $fillable = [
        'video_id',
        'claimant_id',
        'claim_type',
        'reason',
        'copyright_owner_name',
        'status',
        'resolution_notes',
    ];

    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    public function claimant()
    {
        return $this->belongsTo(User::class, 'claimant_id');
    }
}
