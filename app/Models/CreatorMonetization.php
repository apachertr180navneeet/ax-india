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
        'payout_threshold',
        'tax_deduction_rate',
        'payout_method',
        'payout_details',
        'applied_at',
        'approved_at',
    ];

    protected $casts = [
        'ad_revenue_share_percentage' => 'decimal:2',
        'total_earnings' => 'decimal:2',
        'payout_threshold' => 'decimal:2',
        'tax_deduction_rate' => 'decimal:2',
        'payout_details' => 'array',
        'applied_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
