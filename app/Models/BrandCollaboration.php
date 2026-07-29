<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandCollaboration extends Model
{
    use HasFactory;

    protected $fillable = [
        'creator_id',
        'brand_name',
        'campaign_title',
        'campaign_details',
        'compensation',
        'status',
        'deadline_at',
    ];

    protected $casts = [
        'compensation' => 'decimal:2',
        'deadline_at' => 'datetime',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
