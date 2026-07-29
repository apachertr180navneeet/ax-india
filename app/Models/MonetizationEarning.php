<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonetizationEarning extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'video_id',
        'type',
        'amount',
        'tax_deducted',
        'net_amount',
        'description',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'tax_deducted' => 'decimal:2',
        'net_amount' => 'decimal:2',
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
