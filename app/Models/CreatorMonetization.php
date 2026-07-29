<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreatorMonetization extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'ad_revenue_share_percentage',
        'total_earnings',
        'pending_payout',
        'payout_method',
        'payout_details',
        'applied_at',
        'approved_at',
    ];

    protected $casts = [
        'ad_revenue_share_percentage' => 'decimal:2',
        'total_earnings' => 'decimal:2',
        'pending_payout' => 'decimal:2',
        'applied_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
